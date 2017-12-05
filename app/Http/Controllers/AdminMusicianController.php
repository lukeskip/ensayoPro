<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reservation as Reservation;
use Illuminate\Support\Facades\Auth as Auth;
use App\User as User;
use App\Event as Event;
use App\Setting as Setting;
use Jenssegers\Date\Date;

class AdminMusicianController extends Controller
{
	// Muestra mensaje de bienvenida y las reservaciones que tiene
	public function dashboard()
	{   
		$user_id = Auth::user()->id;
		$user 	 = User::with(['bands','reservations'])->find($user_id);
		
		$bands   = $user->bands;
		$bands_ids = [];


		foreach ($bands as $band) {
			$bands_ids[] = $band->id;
		}

		
		$reservations 	= Reservation::where('user_id',$user_id)->where('status','!=','cancelled')->orWhereIn('band_id',$bands_ids)->where('status','!=','cancelled')->orderBy('id','desc')->paginate(10);

		foreach ($reservations as $reservation) {
			$date_starts = new Date($reservation['starts']);
			$date_ends = new Date($reservation['ends']);
			$reservation['date'] = $date_starts->format('d F H:i').'hrs. a '.$date_ends->format('H:i').'hrs.';
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

		$cancel_time = Setting::where('slug','cancel_time')->first()->value;

		$bands = $user->bands; 
		$reservations = Reservation::whereIn('band_id', $bands_ids)->where('status','!=','cancelled')->orWhere('user_id',$user_id)->with('rooms')->where('status','!=','cancelled')->get();

		foreach ($reservations as $reservation) {
			$start  	= new Date ($reservation->starts);
			$now		= Date::now();
			$difference = $now->diffInHours($start);
			if($difference > $cancel_time){
				$reservation['class'] = 'cancel';
			}

			$company = $reservation->rooms->companies;

			if($reservation->rooms->company_address){
				$reservation->description = $company->name." ".$company->address.", ".$company->colony.", ".$company->deputation;
			}
			
		}

		$events	 = Event::whereIn('band_id', $bands_ids)->orWhere('user_id',$user_id)->get();
 
		return view('reyapp.musicians.calendar')->with('reservations',$reservations)->with('events',$events)->with('bands',$bands)->with('cancel_time',$cancel_time)->with('user_id',$user_id);
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
