<?php

namespace App\Http\Controllers;

use App\Reservation as Reservation;
use App\Room as Room;
use App\User as User;
use Illuminate\Support\Facades\Auth as Auth;
use Illuminate\Http\Request;
use DateTime;
use Illuminate\Support\Facades\Validator;

class ReservationController extends Controller
{
    
    // Pantalla de calendario para usuario 'musician'
    public function make_reservation($room_id)
    {
        if($room_id != ''){
            $user_id = Auth::user()->id;
            $bands = User::find($user_id)->companies();
            $room = Room::find($room_id);
            return view('reyapp.rooms.make_reservation')->with('room',$room)->with('bands',$bands); 
        }else{
            return redirect('/salas');
        }
        
    }

    // Pantalla Checkout para usuario 'musician'
    public function checkout(Request $request)
    {   
        $room_id = $request->room_id;
        $room = Room::find($room_id);
        $events = json_decode($request->events,true);

        return view('reyapp.rooms.checkout')->with('room',$room)->with('events',$events);
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
            'name'   => 'required|max:255',
            'room_id'       => 'required|integer',
            'start'         => 'required|date', 
            'end'           => 'required|date',       
        );

        // Validamos todos los campos
        $validator = Validator::make($request->all(), $rules);

        // Si la validación falla, nos detenemos y mandamos false
        if ($validator->fails()) {
            return response()->json(['success' => false,'message'=>'Hay campos con información inválida, por favor revísalos']);
        }

        $user_id = Auth::user()->id;
        $description = $request->name;
        $room_id = $request->room_id;
        $starts = $request->start;
        $ends = $request->end;


        $starts_check = new DateTime($starts);
        $ends_check   = new DateTime($ends);

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

            $room = Room::findOrFail($room_id);
            $room->reservations()->save($reservation);
            
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
