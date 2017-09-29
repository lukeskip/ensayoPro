<?php

namespace App\Http\Controllers;

use App\Reservation as Reservation;
use App\Room as Room;
use App\User as User;
use Illuminate\Support\Facades\Auth as Auth;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    
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
        $title = $request->hola;

        return response()->json(['success' => $title]);
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
        return response()->json(['success' => true]);
    }
}
