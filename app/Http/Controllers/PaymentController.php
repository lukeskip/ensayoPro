<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class PaymentController extends Controller
{

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



}
