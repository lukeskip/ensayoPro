<?php

namespace App\Http\Controllers;

use App\Reservation as Reservation;
use App\Room as Room;
use App\User as User;
use Illuminate\Support\Facades\Auth as Auth;
use Illuminate\Http\Request;
use DateTime;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;


class ReservationController extends Controller
{
    
    // Pantalla de calendario para usuario 'musician'
    public function make_reservation($room_id)
    {
        
        if($room_id != ''){
            $user_id = Auth::user()->id;
            $bands = User::find($user_id)->bands;
            $room = Room::find($room_id);
            $reservations = Reservation::where('room_id',$room_id)->get();
            return view('reyapp.rooms.make_reservation')->with('room',$room)->with('bands',$bands)->with('reservations',$reservations); 
        }else{
            return redirect('/salas');
        }
        
    }

    // Pantalla Checkout para usuario 'musician'
    public function checkout(Request $request)
    {   
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
        return view('reyapp.rooms.checkout')->with('room',$room)->with('events',$events)->with('price',$price)->with('hours',$total_h);
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
            return response()->json(['success' => false,'message'=>'Hay campos con información inválida, por favor revísalos']);
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
