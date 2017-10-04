<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User as User;
use App\Band as Band;
use App\Role as Role;
use Mail;
use Illuminate\Support\Facades\Auth as Auth;
use Illuminate\Support\Facades\Validator;


class BandController extends Controller
{
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

		// Registramos las reglas de validación
		$rules = array(
			'name'				=> 'required|max:255',        
			'genre' 			=> 'required|in:rock,pop,latin,jazz,blues',
			'members'			=> 'required|json',        
		);

		// Validamos todos los campos
		$validator = Validator::make($request->all(), $rules);

		// Si la validación falla, nos detenemos y mandamos false
		if ($validator->fails()) {
			return response()->json(['success' => false,'message'=>'Hay campos con información inválida, por favor revisalos']);
		}

		$role_id = Role::where('name','musician')->first()->id;
		$user_id = Auth::user()->id;
		$band   = new Band();
		$band->name  = $request->name;
		$band->genre = $request->genre;
		$user = User::findOrFail($user_id);
		$user->bands()->save($band);

		$name       = $user->name;
		$band_name  = $band->name;
		$band_id	= $band->id;

		// Creamos a los usuarios y los relacionamos con la banda 
		$members = json_decode($request->input('members'),true);
		foreach ( $members as $member) {
			// Revisamos si el usuario ya existe
			$user = User::where('email', $member['email'])->first();
			
			// Si exite lo agregamos a la banda
			if(!$user){
				// Si no exite lo creamos y lo agregamos a la banda
				$user = new User();
				$user->email = $member['email'];
				$band->users()->save($user);

				$user->roles()->attach($role_id);
				$token = $user->api_token;
				$email = $user->email;


				// Mail::send('reyapp.invitation', ['name'=>$name,'token'=>$token,'band'=>$band_name], function ($message)use($email,$band_name){

				// $message->from('no_replay@reydecibel.com.mx', 'Rey Decibel')->subject('Eres parte de '.$band_name);
				// $message->to($email);

				// });
				
			}else{
				$user->bands()->attach($band_id);
			}
			 
		}

		return response()->json(['success' => true]);
		
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
