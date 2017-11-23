<?php

namespace App\Http\Controllers;

use App\Reservation as Reservation;
use App\Room as Room;
use App\User as User;
use Illuminate\Support\Facades\Auth as Auth;
use Illuminate\Http\Request;
use DateTime;
use Jenssegers\Date\Date;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Mail;


class ReservationController extends Controller
{
    
    // Pantalla de calendario para usuario 'musician'
    public function make_reservation($room_id)
    {
        
        if($room_id != ''){
            $user = Auth::user();
            $user_id = $user->id;
            $bands = User::find($user_id)->bands;
            $room = Room::find($room_id);
            $reservations = Reservation::where('room_id',$room_id)->where('status','!=','cancelled')->get();
            return view('reyapp.rooms.make_reservation')->with('room',$room)->with('bands',$bands)->with('reservations',$reservations)->with('user',$user); 
        }else{
            return redirect('/salas');
        }
        
    }

    

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reservations = Reservation::all();
        return view('reyapp.dashboard')->with('reservations',$reservations);
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

        // Registramos las reglas de validación
        $rules = array(
            'name'          => 'required|max:255',
            'room_id'       => 'required|integer',
            'start'         => 'required|date', 
            'end'           => 'required|date',
            'email'         => 'sometimes|nullable|email',       
        );

        // Validamos todos los campos
        $validator = Validator::make($request->all(), $rules);

        // Si la validación falla, nos detenemos y mandamos false
        if ($validator->fails()) {
            return response()->json(['success' => false,'message'=>'Hay campos con información inválida, recuerda que todos los campos son obligatorios']);
        }

        $user_id        = Auth::user()->id;
        $description    = $request->name." ".$request->email." ".$request->phone;
        $room_id        = $request->room_id;
        $starts         = $request->start;
        $ends           = $request->end;

        // Revisamos que la sala abra ese día, si no, detenemos y mandamos error
        $room = Room::findOrFail($room_id);
        $dow  = explode(',',$room->days);
        $check_dow = new Carbon($starts);
        $dow_names = ['Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'];
        
        if(!in_array($check_dow->dayOfWeek, $dow)){
           return response()->json(['success' => false,'message'=> 'La sala '.$room->name.' está cerrada en '.$dow_names[$check_dow->dayOfWeek]]); 
        };


        $starts_check = new Carbon($starts);
        $ends_check   = new Carbon($ends);

        $starts_time = $starts_check->format('H:i:s');
        $ends_time   = $ends_check->format('H:i:s');

        $open_time   = Carbon::createFromFormat('H', $room->schedule_start)->format('H:i:s');
        $close_time  = Carbon::createFromFormat('H', $room->schedule_end)->format('H:i:s');

        if($starts_time < $open_time){
            return response()->json(['success' => false,'message'=> 'La sala '.$room->name.' abre a las '.$open_time]); 
        }

        if($close_time < $ends_time){
            return response()->json(['success' => false,'message'=> 'La sala '.$room->name.' cierra a las '.$close_time]); 
        }


        $starts_check = $starts_check->modify('+1 minutes');
        $ends_check   = $ends_check->modify('-1 minutes');

        // Revisamos que la reservación no se empalme con otra
        $reservations_check = Reservation::where(
            function ($query) use ($starts_check) {
                $query->where('starts', '<',$starts_check)
                ->where('ends', '>',$starts_check)->where('status','!=','cancelled');
            })->orWhere(function ($query) use ($ends_check) {
                $query->where('starts', '<',$ends_check)
                ->where('ends', '>',$ends_check)->where('status','!=','cancelled');
             })->orWhere(function ($query) use ($starts_check,$ends_check) {
                $query->where('starts', '>',$starts_check)
                ->where('ends', '<',$ends_check)->where('status','!=','cancelled');
            })->get();

        // Si se empalmó revisamos que no sea en la misma sala
        $reservations_check = $reservations_check->where('room_id',$room_id);

        // Si no existe otra reservación en ese horario y esa misma sala lo guardamos
        if($reservations_check->isEmpty()){

            $reservation              = new Reservation();
            $reservation->description = $description;
            $reservation->starts      = $starts;
            $reservation->ends        = $ends;
            $reservation->user_id     = $user_id;

            $reservation->status      = 'confirmed';
            $reservation->is_admin    = true;
            
        
            $prefix = substr($room->companies()->first()->name, 0, 4);
            $prefix = str_replace(' ', '', $prefix);
            $random = str_random(8);

            $code   = strtoupper($prefix.$random);

            $reservation->code = $code;

            $room->reservations()->save($reservation);

            if ($request->has('band')) {
                $band = Band::find($request->band);
                $reservation->attach($band);
            }
            // Carbon::setLocale('es');

            if($room->company_address){
                $room['address']        = $room->companies->address;
                $room['colony']         = $room->companies->colony;
                $room['deputation']     = $room->companies->deputation;
                $room['postal_code']    = $room->companies->postal_code;
                $room['latitude']       = $room->companies->latitude;
                $room['longitude']      = $room->companies->longitude;
                $room['city']           = $room->companies->city;
            }

            $room_name  = $room->name;
            $date       = new Date($starts);;
            $date       = $date->format('l j F Y ');
            $starts     = new Date($starts);
            $ends       = new Date($ends);
            $starts     = $starts->format('H:i');
            $ends       = $ends->format('H:i');
            $email      = $request->email;
            $latitude   = $room->latitude;
            $longitude  = $room->logitude;
            $address    = $room->address.', '.$room->colony.', '.$room->deputation.', '.$room->city ;
            $company    = $room->companies->name;

            if($request->has('email')){
                Mail::send('reyapp.reminder', ['room_name'=>$room_name,'starts'=>$starts,'ends'=>$ends,'date'=>$date,'latitude'=>$latitude,'longitude'=>$longitude,'address'=>$address,'company'=>$company], function ($message)use($email,$room_name){

                $message->from('no_replay@ensayopro.com.mx', 'EnsayoPro')->subject('Tienes una reservación en '.$room_name);
                $message->to($email);

                });  
            }
            

            return response()->json(['success' => true , 'title' => $description,'id'=>$reservation->id,'color'=>$room->color]);



            

        }else{
            // Si si se empalma mandamos mensaje de error
            return response()->json(['success' => false , 'message' => 'Ese horario no está disponible en esa sala']);
        }
        
        
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
        $user_id = Auth::user()->id;
        $reservation = Reservation::find($id);
        if($user_id == $reservation->user_id);{
            $reservation->delete();
        }
        return response()->json(['success' => true]);
    }
}
