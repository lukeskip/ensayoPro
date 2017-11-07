<?php

namespace App\Http\Controllers;

use App\Role as Role;
use App\Company as Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as Auth;
use App\User as User;
use Illuminate\Support\Facades\Validator;

class CompanyController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	
		
	public function register_user()
	{
		$role = Role::where('name','company')->first();
		return view('reyapp.register_user_company')->with('role',$role->token);
	}

	public function register_company()
	{    
		return view('reyapp.companies.register_company');
	}

	public function index()
	{
		$companies = Company::all();
		return view('reyapp.companies')->with('companies',$companies);
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
			'name'              => 'required|max:255',
			'address'           => 'required|max:1000',
			'colony'            => 'required|max:100',
			'deputation'        => 'required|max:100',
			'postal_code'       => 'required|max:20',
			'city'              => 'required|max:100',
			'phone'             => 'required|max:30',
			'rfc'               => 'required|max:30',
			'latitude'          => 'required|max:20',
			'longitude'         => 'required|max:20',       
		);

		// Validamos todos los campos
		$validator = Validator::make($request->all(), $rules);

		// Si la validación falla, nos detenemos y mandamos false
		if ($validator->fails()) {
			// return response()->json(['success' => false,'message'=>'Hay campos con información inválida, por favor revísalos']);
			return response()->json($validator->messages(), 200);
		}

		$user_id = Auth::user()->id;
		$company                 = new Company();
		$company->legalname      = $request->legalname;
		$company->clabe          = $request->clabe;
		$company->name           = $request->name;
		$company->address        = $request->address;
		$company->colony         = $request->colony;
		$company->deputation     = $request->deputation;
		$company->postal_code    = $request->postal_code;
		$company->city           = $request->city;
		$company->phone          = $request->phone;
		$company->rfc            = $request->rfc;
		$company->latitude       = $request->latitude;
		$company->longitude      = $request->longitude;
		$company->bank           = $request->bank_entity;
		$company->account_holder = $request->account_holder;
		$company->status         = 'inactive';
		
		$user = User::findOrFail($user_id);
		$user->companies()->save($company);

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
		$company = Company::findOrFail($id);

		
		if($company->status == 'inactive'){
			$company['status'] = 'Inactiva';
		}

		if($company->status == 'active'){
			$company['status'] = 'Activa';
		}
		

		return view('reyapp.companies.settings')->with('company',$company);
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
		$user_id = Auth::user()->id;
		$company = Company::with('users')->find($id);
		$company_user = $company->users->first()->id;

		// verificamos que el usuario sea dueño de la información
		if($user_id != $company_user){
			return response()->json(['success' => false,'messages'=>'No tienes privilagios necesarios']); 
		}

		if ($request->has('name')) {

			if($request->name != $company->name){
					$validator = Validator::make($request->all(), [
					'name' => 'required|unique:companies|max:255',
				]);

				if ($validator->fails()) {
	            	return response()->json(['success' => false,$validator->errors()]);
	        	}

	    		$company->name = $request->name;
				$company->save();
				return response()->json(['success' => true,'description'=>$company->name]);
			}else{
				return response()->json(['success' => true,'description'=>$company->name]);
			}	
			 
		}

		if ($request->has('legalname')) {
		   if($request->legalname != $company->legalname){
					$validator = Validator::make($request->all(), [
					'legalname' => 'required|max:255',
				]);

				if ($validator->fails()) {
	            	return response()->json(['success' => false,$validator->errors()]);
	        	}

	    		$company->legalname = $request->legalname;
				$company->save();
				return response()->json(['success' => true,'description'=>$company->legalname]);
			}else{
				return response()->json(['success' => true,'description'=>$company->legalname]);
			} 
		}

		if ($request->has('phone')) {
		   if($request->phone != $company->phone){
					$validator = Validator::make($request->all(), [
					'phone' => 'required|max:255',
				]);

				if ($validator->fails()) {
	            	return response()->json(['success' => false,$validator->errors()]);
	        	}

	    		$company->phone = $request->phone;
				$company->save();
				return response()->json(['success' => true,'description'=>$company->phone]);
			}else{
				return response()->json(['success' => true,'description'=>$company->phone]);
			} 
		}

		if ($request->has('rfc')) {
		   if($request->rfc != $company->rfc){
					$validator = Validator::make($request->all(), [
					'rfc' => 'required|max:255',
				]);

				if ($validator->fails()) {
	            	return response()->json(['success' => false,$validator->errors()]);
	        	}

	    		$company->rfc = $request->rfc;
				$company->save();
				return response()->json(['success' => true,'description'=>$company->rfc]);
			}else{
				return response()->json(['success' => true,'description'=>$company->rfc]);
			} 
		}

		if ($request->has('clabe')) {
		   if($request->clabe != $company->clabe){
					$validator = Validator::make($request->all(), [
					'clabe' => 'required|max:255',
				]);

				if ($validator->fails()) {
	            	return response()->json(['success' => false,$validator->errors()]);
	        	}

	    		$company->clabe = $request->clabe;
				$company->save();
				return response()->json(['success' => true,'description'=>$company->clabe]);
			}else{
				return response()->json(['success' => true,'description'=>$company->clabe]);
			} 
		}

		if ($request->has('bank')) {
		  if($request->clabe != $company->clabe){
					$validator = Validator::make($request->all(), [
					'clabe' => 'required|max:255',
				]);

				if ($validator->fails()) {
	            	return response()->json(['success' => false,$validator->errors()]);
	        	}

	    		$company->clabe = $request->clabe;
				$company->save();
				return response()->json(['success' => true,'description'=>$company->clabe]);
			}else{
				return response()->json(['success' => true,'description'=>$company->clabe]);
			} 
		}

		if ($request->has('account_holder')) {
		   if($request->account_holder != $company->account_holder){
					$validator = Validator::make($request->all(), [
					'account_holder' => 'required|max:255',
				]);

				if ($validator->fails()) {
	            	return response()->json(['success' => false,$validator->errors()]);
	        	}

	    		$company->account_holder = $request->account_holder;
				$company->save();
				return response()->json(['success' => true,'description'=>$company->account_holder]);
			}else{
				return response()->json(['success' => true,'description'=>$company->account_holder]);
			} 
		}

		if ($request->has('address')) {
		   $company->address = $request->address;
		   if($request->latitude != '' and $request->longitude != ''){
				$company->latitude = $request->latitude;
				$company->longitude = $request->longitude;
		   }
		   $company->save();
		   return response()->json(['success' => true,'description'=>$company->address,'latitude'=>$request->latitude,'longitude'=>$request->longitude]); 
		}

		if ($request->has('colony')) {
		   $company->colony = $request->colony;
		   if($request->latitude != '' and $request->longitude != ''){
				$company->latitude = $request->latitude;
				$company->longitude = $request->longitude;
		   }
		   $company->save();
		   return response()->json(['success' => true,'description'=>$company->colony,'latitude'=>$request->latitude,'longitude'=>$request->longitude]); 
		}

		if ($request->has('deputation')) {
		   $company->deputation = $request->deputation;
		   if($request->latitude != '' and $request->longitude != ''){
				$company->latitude = $request->latitude;
				$company->longitude = $request->longitude;
		   }
		   
		   $company->save();
		   return response()->json(['success' => true,'description'=>$company->deputation,'latitude'=>$request->latitude,'longitude'=>$request->longitude]); 
		}

		if ($request->has('postal_code')) {
		   $company->postal_code = $request->postal_code;
		   if($request->latitude != '' and $request->longitude != ''){
				$company->latitude = $request->latitude;
				$company->longitude = $request->longitude;
		   }
		   $company->save();
		   return response()->json(['success' => true,'description'=>$company->postal_code,'latitude'=>$request->latitude,'longitude'=>$request->longitude]); 
		}

		if ($request->has('city')) {
		   $company->city = $request->city;
		   $company->latitude = $request->latitude;
		   $company->longitude = $request->longitude;
		   $company->save();
		   return response()->json(['success' => true,'description'=>$company->city,'latitude'=>$request->latitude,'longitude'=>$request->longitude]); 
		}

		if ($request->has('latitude')) {
		   if($request->latitude != '' and $request->longitude != ''){
				$company->latitude = $request->latitude;
				$company->longitude = $request->longitude;
		   }
		   $company->save();
		   return response()->json(['success' => true,'latitude'=>$request->latitude,'longitude'=>$request->longitude]); 
		}
		 
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
