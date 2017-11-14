<?php

namespace App\Http\Controllers;

use App\Role as Role;
use App\Company as Company;
use App\Room as Room;
use Illuminate\Support\Facades\DB;
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
		$user_id = Auth::user()->id;
		$company = User::where('id',$user_id)->first()->companies;

		if(!$company->isEmpty()){
			return view('reyapp.companies.register_company')->with('message','Ya registraste una compañía');
		}else{
			return view('reyapp.companies.register_company');
		}
		
	}

	public function index()
	{
		$companies = Company::paginate();

		// $companies = Company::with('rooms')->leftJoin('ratings', 'ratings.room_id', '=', 'rooms.id')->select('rooms.*', DB::raw('AVG(score) as average' ))->groupBy('rooms.id');

		// $companies = Room::leftJoin('companies', 'companies.id', '=', 'rooms.company_id')->select('companies.*','rooms.*')->leftJoin('ratings', 'ratings.room_id', '=', 'rooms.id')->select('rooms.*','companies.*', DB::raw('AVG(score) as average' ))->groupBy('rooms.id');
		
		return view('reyapp.companies')->with('companies',$companies);
	}

	public function index_company()
	{
		$user_id = Auth::user()->id;
		$companies = User::find($user_id)->companies();

		// Cuantificamos y promediamos las opiniones en base 5
        $quality = 0;
        $sumRatings = count($companies->$rooms->ratings);

        if($sumRatings > 0){
            foreach ($room->ratings as $rating) {
                $quality += $rating->score;
            }

            $quality = $quality / $sumRatings;
            $room['score']    = round($quality,1, PHP_ROUND_HALF_UP);
        }
        
        $company->ratings = $sumRatings;

		
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
		$company->bank           = $request->bank;
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
		$user_id = Auth::user()->id;
		$company = Company::with('users')->find($id);
		$company_user = $company->users->first()->id;
		$role = User::find($user_id)->roles->first()->name;

		// verificamos que el usuario sea dueño de la información
		if($user_id != $company_user and $role != 'admin'){
			return response()->json(['success' => false,'messages'=>'No tienes privilegios necesarios']); 
		}


		$rooms 	 = $company->rooms;
		foreach ($rooms as $room) {
			// Cuantificamos y promediamos las opiniones en base 5
	        $quality = 0;
	        $sumRatings = count($room->ratings);

	        if($sumRatings > 0){
	            foreach ($room->ratings as $rating) {
	                $quality += $rating->score;
	            }

	            $quality = $quality / $sumRatings;
	            $room['score']    = round($quality,1, PHP_ROUND_HALF_UP);
	        }
	        
	        $room['ratings'] = $sumRatings;
		}
	
		return view('reyapp.companies.single')->with('company',$company)->with('rooms',$rooms);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit()
	{
		$user_id = Auth::user()->id;
		$company = User::find($user_id);
		$company = $company->companies->first();

		
		if($company->status == 'inactive'){
			$company['status'] = 'Inactiva';
		}

		if($company->status == 'active'){
			$company['status'] = 'Activa';
		}
		

		return view('reyapp.companies.settings')->with('company',$company);
	}

	public function edit_admin($id)
	{
		
		$company = Company::find($id);

		
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
		$role = User::find($user_id)->roles->first()->name;

		// verificamos que el usuario sea dueño de la información
		if($user_id != $company_user  and $role != 'admin' ){
			return response()->json(['success' => false,'messages'=>'No tienes privilegios necesarios']); 
		}

		// Registramos las reglas de validación
		$rules = array(
			'name'              => 'required|unique:companies,name,'.$id.'|max:255',
			'address'           => 'required|max:1000',
			'colony'            => 'required|max:100',
			'deputation'        => 'required|max:100',
			'postal_code'       => 'required|max:20',
			'city'              => 'required|max:100',
			'phone'             => 'required|max:30',
			'rfc'               => 'required|max:30',
			'latitude'          => 'max:20',
			'longitude'         => 'max:20',       
		);

		// Validamos todos los campos
		$validator = Validator::make($request->all(), $rules);

		// Si la validación falla, nos detenemos y mandamos false
		if ($validator->fails()) {
			// return response()->json(['success' => false,'message'=>'Hay campos con información inválida, por favor revísalos']);
			return response()->json(['success'=> false,$validator->messages()], 200);
		}

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
		
		
		$company->bank           = $request->bank;
		$company->account_holder = $request->account_holder;
		
		if ($request->has('latitude') and $request->has('longitude')) {
			$company->latitude       = $request->latitude;
			$company->longitude      = $request->longitude;
		}


		$company->save();

		return response()->json(['success' => true]);
		 
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
