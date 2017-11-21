<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reservation as Reservation;
use App\Room as Room;
use App\User as User;
use Carbon\Carbon;
use Mail;


class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //Constructor
    public function __construct()
    {
        \Conekta\Conekta::setApiKey(env('CONEKTA_SECRET_KEY'));
        \Conekta\Conekta::setApiVersion("2.0.0");
    }

//Creando un pago mediante tarjeta
    public function CreatePayCard(Request $request)
    {
        $valid_order =
        array(
            'line_items'=> array(
                array(
                    'name'        => $request->input('room'),
                    'description' => 'Renta de instalaciones',
                    'unit_price'  => $request->input('price'),
                    'quantity'    => $request->input('quantity')
                )
            ),
            'currency'    => 'MXN',
          //'metadata'    => array('test' => 'extra info'),
            'charges'     => array(
              array(
                  'payment_method' => array(
                      'type'       => 'card',
                      'token_id' => $request->input('token')
                  )
                   //'amount' => $precio
              )
          ),
            'currency'      => 'MXN',
            'customer_info' => array(
                'name'  => $request->input('name'),
                'phone' => $request->input('tel'),
                'email' => $request->input('email')
            )
        );

        try {
          $order = \Conekta\Order::create($valid_order);

          $pI = $order['id'];
          $pM = $order->charges[0]->payment_method->type;
          $pR = 0;
          $pS = $order['payment_status'];

          $rsp = array("id"=>$pI,"method"=>$pM,"reference"=>$pR,"status"=>$pS);

                //Establecido para retornar el estado de pago unicamente (se puede recibir todo el data)
              // return $this->Response(1,$rsp);
            return $pS;
          } catch (\Conekta\ProcessingError $e){ 

              return $this->Response(0,$e);
          } catch (\Conekta\ParameterValidationError $e){
            return $this->Response(0,$e);
        } 
        catch (\Conekta\Handler $e){
            return $this->Response(0,$e);
        }

    }

    //Creando un pago mediante Oxxo.
    public function CreatePayOxxo(Request $request)
    {

        $expire = strtotime(date("Y-m-d H:i:s")) + "36000";
        $valid_order =
        array(
            'line_items'=> array(
              array(
                'name'        => $request->input('room'),
                'description' => 'Renta de instalaciones',
                'unit_price'  => $request->input('price'),
                'quantity'    => $request->input('quantity')
            )
        ),
        'currency'      => 'MXN',
          // 'metadata'    => array('test' => 'extra info'),
        'charges'     => array(
          array(
              'payment_method' => array(
                  'type'       => 'oxxo_cash',
                  'expires_at' => $expire
              )
                   //'amount' => $precio
          )
        ),
        'currency'      => 'MXN',
        'customer_info' => array(
            'name'  => $request->input('name'),
            'phone' => $request->input('tel'),
            'email' => $request->input('email')
        )
    );

    try {
      $order = \Conekta\Order::create($valid_order);
          $pI = $order['id'];
          $pM = $order->charges[0]->payment_method->type;
          $pR = $order->charges[0]->payment_method->reference;
          $pS = $order['payment_status'];

          $rsp = array("id"=>$pI,"method"=>$pM,"reference"=>$pR,"status"=>$pS);
        //INFORMACIÓN IMPORTANTE DEL JSON DE RESPUESTA.
        // ID: $order->id
        // Método de pago: $order->charges[0]->payment_method->service_name
        // Referencia: $order->charges[0]->payment_method->reference
        // Total: $order->amount/100 . $order->currency (lo manda en centavos, por eso se divide entre 100)
        // Orden:
        // Cantidad:  $order->line_items[0]->quantity
        // Nombre: $order->line_items[0]->name
        // Precio unitario $order->line_items[0]->unit_price/100

          return $this->Response(1,$rsp);

      } catch (\Conekta\ProcessingError $e){ 
        return $this->Response(0,$e);
    } catch (\Conekta\ParameterValidationError $e){
        return $this->Response(0,$e);
    } 
    catch (\Conekta\Handler $e){
        return $this->Response(0,$e);
    }

    }

    //Manejo de respuestas
    private function Response($success,$result)
    {
        if($success==0){ $result=$result->getMessage(); } 
        $out = array("type"=>$success,"data"=>$result);
         return view('reyapp.testResponse')->with('response',$out); 
    }

    public function payment_form(Request $request){

        $room_id    = $request->room_id;
        $room       = Room::find($room_id);
        $events     = json_decode($request->events,true);
        $total_h    = 0;
        
        for($i=0;$i<count($events);$i++){
            $starts_check = $events[$i]['start'];
            $ends_check =$events[$i]['end'];

            $reservations_check = Reservation::where(
            function ($query) use ($starts_check) {
                $query->where('starts', '<',$starts_check)
                ->where('ends', '>',$starts_check);
            })->orWhere(function ($query) use ($ends_check) {
                $query->where('starts', '<',$ends_check)
                ->where('ends', '>',$ends_check);
             })->orWhere(function ($query) use ($starts_check,$ends_check) {
                $query->where('starts', '>',$starts_check)
                ->where('ends', '<',$ends_check);
            })->get();

            

            // Si se empalmó revisamos que no sea en la misma sala
            $reservations_check = $reservations_check->where('room_id',$room_id);

            // Si no existe otra reservación en ese horario y esa misma sala ponemos el status en available
            if($reservations_check->isEmpty()){
                $prefix = substr($room->companies()->first()->name, 0, 4);
                $prefix = str_replace(' ', '', $prefix);
                $random = str_random(8);
                $code   = strtoupper($prefix.$random);

                $months = array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
                
                $events[$i]['code']         = $code; 
                $events[$i]['status']       = 'available';
                $start                      = new Carbon($events[$i]['start']);
                $end                        = new Carbon($events[$i]['end']);
                $events[$i]['day']          = $start->format('d');
                $events[$i]['month']        = $months[$start->format('m')];
                $events[$i]['start_time']   = $start->format('H:i');
                $events[$i]['end_time']     = $end->format('H:i');
                
               
                $total_h += $start->diffInHours($end);     


            }else{
                $events[$i]['status'] = 'unavailable';
            }
        }
        
        $price = $total_h * $room->price;


        $method = $request->payment_method;
        $hours  = $request->hours;

        return view('reyapp.rooms.checkout')->with('method',$method)->with('price',$price)->with('hours',$hours)->with('room',$room)->with('events',$events)->with('price',$price)->with('hours',$total_h);
    }

    public function index()
    {
        return view ('reyapp.payments.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
