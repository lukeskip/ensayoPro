<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reservation as Reservation;
use Illuminate\Support\Facades\Auth as Auth;
use App\User as User;
use App\Event as Event;

class AdminMusicianController extends Controller
{
	// Muestra mensaje de bienvenida y las reservaciones que tiene
	public function dashboard()
	{   
		$user_id = Auth::user()->id;
		$user = User::find($user_id);

		if($user->bands->count() < 1){
		   $reservations = $user->reservations;  
		}else{
			$reservations = $user->bands->reservations;
		}
		
		

		return view('reyapp.musicians.dashboard')->with('reservations',$reservations);
	}

	 public function calendar()
	{   
		$user_id = Auth::user()->id;
		$user = User::find($user_id);
		$bands_ids  = [];
		foreach ($user->bands as $band) {
			$bands_ids[] = $band->id;
		}

		$bands = $user->bands; 
		$reservations = Reservation::whereIn('band_id', $bands_ids)->orWhere('user_id',$user_id)->get();

		$events		  = Event::whereIn('band_id', $bands_ids)->orWhere('user_id',$user_id)->get();
 
		return view('reyapp.musicians.calendar')->with('reservations',$reservations)->with('events',$events)->with('bands',$bands);
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		//
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
