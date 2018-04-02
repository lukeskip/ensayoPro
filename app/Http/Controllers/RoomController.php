<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as Auth;
use App\Room as Room;
use App\User as User;
use App\Type as Type;
use App\Company as Company;
use App\MediaItem as MediaItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Jenssegers\Date\Date;
use DateTime;

class RoomController extends Controller
{

	public function delete_image($id){
		$image = MediaItem::find($id);
		File::delete(url('imagenes/'.$image->name));
		$image->delete();
		return response()->json(['success' => true,'message'=>'La imagen fue borrada fue borrado']); 
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	// DEL TYPE SALA DE ENSAYO
	public function index()
	{   
		$items_per_page = 10;
		$order = 'quality_up';
		$role  = '';
		$now = Date::now();

		if(!Auth::guest()){
			$user_id = Auth::user()->id;
			$role = User::find($user_id)->roles->first()->name;  
		}
		

		$rooms = Room::whereHas('types',function($query){
				$query->where('name','room');
			})->with(array('promotions' => function($query) use($now) {
				$query->where('valid_ends','>=',$now)->where('status','published')->orderBy('valid_ends', 'DESC');
    		}))->leftJoin('room_promotion',function($leftjoin) use($now) {
				$leftjoin->on('room_promotion.room_id','=','rooms.id')->where('room_promotion.pivot_status','=','published')->where('room_promotion.pivot_valid_ends','>=',$now);
    		})->groupBy('rooms.id')->leftJoin('ratings', 'ratings.room_id', '=', 'rooms.id')->groupBy('rooms.id')->select('rooms.*',DB::raw('(CASE WHEN  room_promotion.room_id != "NULL" THEN 1 ELSE 0 END) AS promotion' ), DB::raw('AVG(score) as average' ), DB::raw('COUNT(ratings.id) as total_ratings'));

		// Actuamos dependiento los filtros que tengamos diponibles
		if(request()->has('order')){
			
			if(request()->order == 'price_up'){
			
				$rooms = $rooms->orderBy('price','ASC');
			
			}else if(request()->order == 'price_down'){
			
				$rooms = $rooms->orderBy('price','DESC');
			
			}else if(request()->order == 'quality_up'){

				$rooms = $rooms->orderBy('average','ASC');

			}else if(request()->order == 'quality_down'){

				$rooms = $rooms->orderBy('average','DESC');
			}

		}else{

			$rooms = $rooms->orderBy('promotion','DESC')->orderBy('average','DESC')->orderBy('total_ratings','DESC');


		}

		if(request()->has('colonia')){	
			if($role == 'admin'){ 
				$rooms = $rooms->where('colony',request()->colonia)->orWhereHas('companies', function ($query) {
	    			$query->where('colony', 'like',request()->deleg);
				});
			}else{
				$rooms = $rooms->where('colony',request()->deleg )->orWhereHas('companies', function ($query) {
    			$query->where('colony', 'like', request()->deleg );
				})->where('status','active');
			}
			
		}

		if(request()->has('deleg')){
			if($role == 'admin'){ 
				$rooms = $rooms->where('deputation',request()->deleg )->orWhereHas('companies', function ($query) {
    			$query->where('deputation', 'like', request()->deleg );
			});
			}else{
				$rooms = $rooms->where('deputation', request()->deleg )->orWhereHas('companies', function ($query) {
    			$query->where('deputation', 'like', request()->deleg );
			})->where('status','active');
			}
			
		}

		if(request()->has('ciudad')){
			if($role == 'admin'){ 
				$rooms = $rooms->where('city',request()->ciudad )->orWhereHas('companies', function ($query) {
    			$query->where('city', 'like', request()->ciudad );
			});
			}else{
				$rooms = $rooms->where('city',request()->ciudad )->orWhereHas('companies', function ($query) {
    			$query->where('city', 'like', request()->ciudad);
			})->where('status','active');
			}
			
		}

		if(request()->has('buscar')){	
			$rooms = $rooms->where('name', 'LIKE', '%' . request()->buscar . '%')->orWhere('equipment', 'LIKE', '%' . request()->buscar . '%')->orWhereHas('companies', function($query){
				$query->where('name', 'LIKE', '%' . request()->buscar . '%');
			});
		
		}

		if($role != 'admin'){ 
			$rooms = $rooms->where('status','active')->whereHas('companies', function ($query) {
    			$query->where('status', '!=', 'deleted');
			}); 
		}
		
		$rooms = $rooms->paginate($items_per_page);

		
		// Si tienen la misma dirección de la compañía la asignamos y la mandamos dentro del mismo objeto
		foreach ($rooms as $room) {

			if($room->company_address){
				$room['address']        = $room->companies->address;
				$room['colony']         = $room->companies->colony;
				$room['deputation']     = $room->companies->deputation;
				$room['postal_code']    = $room->companies->postal_code;
				$room['latitude']       = $room->companies->latitude;
				$room['longitude']      = $room->companies->longitude;
				$room['city']      		= $room->companies->city;
			}
			
			// Cuantificamos y promediamos las calificaiones
			$quality = 0;
			$sumRatings = count($room->ratings);

			if($sumRatings > 0){
				foreach ($room->ratings as $rating) {
					$quality += $rating->score;
				}

				$quality = $quality / $sumRatings;
				$room['score']    = $quality;
			}
			
			$room['ratings'] = $sumRatings;

			
			// $room->promotions = $room->promotions->where('valid_ends', '>=', $now)->where('status','published');

			if ($room->promotions){
				
				foreach ($room->promotions as $promotion) {
					$now                = Date::now();
					$finishs            = new Date($promotion->valid_ends);
					if($now <= $finishs){
						$finishs            = $finishs->diffInDays($now);
						$promotion['finishs']  = 'Le quedan '.$finishs.' día(s)';  
					}else{
						$promotion['finishs']  = 'Esta promoción caducó';   
					}


					if($promotion->rule == 'hours'){
						$rules = " en la reserva de al menos ".$promotion->min_hours.' horas';
					}elseif ($promotion->rule == 'schedule') {
						$days_array = ['Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'];
						$days_valid = '';
						$days = explode(',',$promotion->days);
						foreach ($days as $key => $value) {

							if ($key === end($days)){
								$days_valid .= $days_array[$value];
							}else{
								$days_valid .= $days_array[$value].', ';
							}
						}

						$rules = ' en la reserva de tu ensayo entre las '.$promotion->schedule_starts.':00 y las '.$promotion->schedule_ends.':00 los días '.$days_valid;
					}

					if ($promotion->type == 'percentage'){

						$description = $promotion->value.'% de descuento '.$rules;
						$tag = $promotion->value.'% ';
					}elseif ($promotion->type == 'hour_price'){
						$description = '$'.$promotion->value.' precio por hora '.$rules;
						$tag = '$'.$promotion->value.'p/hora ';
					}
					
					$promotion->description = $description;
					$promotion->tag 		= $tag;
				}
			}
		}


		$companies = Company::orderBy('name', 'desc')->get();
		$order = request()->order;
		$deputations = $rooms->unique('deputation')->values()->all();
		$cities = $rooms->unique('city')->values()->all();
		return view('reyapp.rooms.list')->with('rooms',$rooms)->with('companies',$companies)->with('order',$order)->with('role',$role)->with('deputations',$deputations)->with('cities',$cities)->with('now',$now);
	}


	public function index_studios(){
		$items_per_page = 10;
		$order = 'quality_up';
		$role  = '';
		$now = Date::now();

		if(!Auth::guest()){
			$user_id = Auth::user()->id;
			$role = User::find($user_id)->roles->first()->name;  
		}
		

		$rooms = Room::whereHas('types',function($query){
				$query->where('name','studio');
			})->with(array('promotions' => function($query) use($now) {
				$query->where('valid_ends','>=',$now)->orderBy('valid_ends', 'DESC')->where('status','published');
    		}))->leftJoin('room_promotion','room_promotion.room_id','=','rooms.id')->groupBy('rooms.id')->leftJoin('ratings', 'ratings.room_id', '=', 'rooms.id')->groupBy('rooms.id')->select('rooms.*',DB::raw('(CASE WHEN  room_promotion.room_id != "NULL" THEN 1 ELSE 0 END) AS promotion' ), DB::raw('AVG(score) as average' ), DB::raw('COUNT(ratings.id) as total_ratings'));

		// Actuamos dependiento los filtros que tengamos diponibles
		if(request()->has('order')){
			
			if(request()->order == 'price_up'){
			
				$rooms = $rooms->orderBy('price','ASC');
			
			}else if(request()->order == 'price_down'){
			
				$rooms = $rooms->orderBy('price','DESC');
			
			}else if(request()->order == 'quality_up'){

				$rooms = $rooms->orderBy('average','ASC');

			}else if(request()->order == 'quality_down'){

				$rooms = $rooms->orderBy('average','DESC');
			}

		}else{

			$rooms = $rooms->orderBy('promotion','DESC')->orderBy('average','DESC')->orderBy('total_ratings','DESC');


		}

		if(request()->has('colonia')){	
			if($role == 'admin'){ 
				$rooms = $rooms->where('colony',request()->colonia)->orWhereHas('companies', function ($query) {
	    			$query->where('colony', 'like',request()->deleg);
				});
			}else{
				$rooms = $rooms->where('colony',request()->deleg )->orWhereHas('companies', function ($query) {
    			$query->where('colony', 'like', request()->deleg );
				})->where('status','active');
			}
			
		}

		if(request()->has('deleg')){
			if($role == 'admin'){ 
				$rooms = $rooms->where('deputation',request()->deleg )->orWhereHas('companies', function ($query) {
    			$query->where('deputation', 'like', request()->deleg );
			});
			}else{
				$rooms = $rooms->where('deputation', request()->deleg )->orWhereHas('companies', function ($query) {
    			$query->where('deputation', 'like', request()->deleg );
			})->where('status','active');
			}
			
		}

		if(request()->has('ciudad')){
			if($role == 'admin'){ 
				$rooms = $rooms->where('city',request()->ciudad )->orWhereHas('companies', function ($query) {
    			$query->where('city', 'like', request()->ciudad );
			});
			}else{
				$rooms = $rooms->where('city',request()->ciudad )->orWhereHas('companies', function ($query) {
    			$query->where('city', 'like', request()->ciudad);
			})->where('status','active');
			}
			
		}

		if(request()->has('buscar')){	
			$rooms = $rooms->where('name', 'LIKE', '%' . request()->buscar . '%')->orWhere('equipment', 'LIKE', '%' . request()->buscar . '%')->orWhereHas('companies', function($query){
				$query->where('name', 'LIKE', '%' . request()->buscar . '%');
			});
		
		}

		if($role != 'admin'){ 
			$rooms = $rooms->where('status','active')->whereHas('companies', function ($query) {
    			$query->where('status', '!=', 'deleted');
			}); 
		}
		
		$rooms = $rooms->paginate($items_per_page);

		

		
		// Si tienen la misma dirección de la compañía la asignamos y la mandamos dentro del mismo objeto
		foreach ($rooms as $room) {

			if($room->company_address){
				$room['address']        = $room->companies->address;
				$room['colony']         = $room->companies->colony;
				$room['deputation']     = $room->companies->deputation;
				$room['postal_code']    = $room->companies->postal_code;
				$room['latitude']       = $room->companies->latitude;
				$room['longitude']      = $room->companies->longitude;
				$room['city']      		= $room->companies->city;
			}
			
			// Cuantificamos y promediamos las calificaiones
			$quality = 0;
			$sumRatings = count($room->ratings);

			if($sumRatings > 0){
				foreach ($room->ratings as $rating) {
					$quality += $rating->score;
				}

				$quality = $quality / $sumRatings;
				$room['score']    = $quality;
			}
			
			$room['ratings'] = $sumRatings;

			
			// $room->promotions = $room->promotions->where('valid_ends', '>=', $now)->where('status','published');

			if ($room->promotions){
				
				foreach ($room->promotions as $promotion) {
					$now                = Date::now();
					$finishs            = new Date($promotion->valid_ends);
					if($now <= $finishs){
						$finishs            = $finishs->diffInDays($now);
						$promotion['finishs']  = 'Le quedan '.$finishs.' día(s)';  
					}else{
						$promotion['finishs']  = 'Esta promoción caducó';   
					}


					if($promotion->rule == 'hours'){
						$rules = " en la reserva de al menos ".$promotion->min_hours.' horas';
					}elseif ($promotion->rule == 'schedule') {
						$days_array = ['Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'];
						$days_valid = '';
						$days = explode(',',$promotion->days);
						foreach ($days as $key => $value) {

							if ($key === end($days)){
								$days_valid .= $days_array[$value];
							}else{
								$days_valid .= $days_array[$value].', ';
							}
						}

						$rules = ' en la reserva de tu ensayo entre las '.$promotion->schedule_starts.':00 y las '.$promotion->schedule_ends.':00 los días '.$days_valid;
					}

					if ($promotion->type == 'percentage'){

						$description = $promotion->value.'% de descuento '.$rules;
						$tag = $promotion->value.'% ';
					}elseif ($promotion->type == 'hour_price'){
						$description = '$'.$promotion->value.' precio por hora '.$rules;
						$tag = '$'.$promotion->value.'p/hora ';
					}
					
					$promotion->description = $description;
					$promotion->tag 		= $tag;
				}
			}
		}

		$companies = Company::orderBy('name', 'desc')->get();
		$order = request()->order;
		$deputations = $rooms->unique('deputation')->values()->all();
		$cities = $rooms->unique('city')->values()->all();
		return view('reyapp.studios.list')->with('rooms',$rooms)->with('companies',$companies)->with('order',$order)->with('role',$role)->with('deputations',$deputations)->with('cities',$cities)->with('now',$now);
	}


	public function index_company()
	{
		$items_per_page = 10;
		$order = 'quality_up';
		$user_id = Auth::user()->id;
		$rooms_wrap = [];


		$user = User::find($user_id);
		$companies = $user->companies()->with('rooms')->get();

		$rooms = collect([]);
		$room_ids  = [];

		foreach ($companies as $company) {
			foreach ($company->rooms as $room) {
				$rooms->push($room);
			}
		}

		// Si tienen la misma dirección de la compañía la asignamos y la mandamos dentro del mismo objeto
		
		foreach ($rooms as $room) {

			if($room->company_address){
				$room['address']        = $room->companies->address;
				$room['colony']         = $room->companies->colony;
				$room['deputation']     = $room->companies->deputation;
				$room['postal_code']    = $room->companies->postal_code;
				$room['latitude']       = $room->companies->latitude;
				$room['longitude']      = $room->companies->longitude;
			}
			
			// Cuantificamos y promediamos las calificaiones
			$quality = 0;
			$sumRatings = count($room->ratings);

			if($sumRatings > 0){
				foreach ($room->ratings as $rating) {
					$quality += $rating->score;
				}

				$quality = $quality / $sumRatings;
				$room['score']    = $quality;
			}
			
			$room['ratings'] = $sumRatings;
		}
		
		
		$companies = Company::orderBy('name', 'desc')->get();
		$order = request()->order;

		return view('reyapp.rooms.list_company')->with('rooms',$rooms)->with('companies',$companies)->with('order',$order);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{

		$user_id = Auth::user()->id;
		$companies = User::where('id',$user_id)->with('companies')->first();
		$company = $companies->companies->first();
		$types 	 = Type::all();
		return view('reyapp.rooms.register_room')->with('company',$company)->with('types',$types)->with('role',$this->get_role());
	}

	public function create_admin()
	{
		
		$types 	 = Type::all();
		return view('reyapp.rooms.register_room_admin')->with('types',$types)->with('role',$this->get_role());
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
			'description'       => 'required|max:255',
			'equipment'         => 'required|max:1000',
			'instructions'      => 'max:255',
			'days'              => 'required|max:255',
			'schedule_start'    => 'required|max:3', 
			'schedule_end'      => 'required|max:3',
			'color'             => 'required|max:10',        
			'price'             => 'required|integer',        
		);

		// Validamos todos los campos
		$validator = Validator::make($request->all(), $rules);

		// Si la validación falla, nos detenemos y mandamos false
		if ($validator->fails()) {
			return response()->json(['success' => false,'message'=>'Hay campos con información inválida, por favor revísalos']);
		}
		 
		$is_admin             	= $request->is_admin;
		$company_id             = $request->company;
		$room                   = new Room();
		$room->name             = $request->name;
		$room->company_name     = $request->company_name;
		$room->price            = $request->price;
		$room->description      = $request->description;
		$room->equipment        = $request->equipment;
		$room->schedule_start   = $request->schedule_start;
		$room->schedule_end     = $request->schedule_end;
		$room->color            = $request->color;
		$room->instructions     = $request->instructions;
		$room->status           = 'active';
		$room->type_id          = $request->type;
		$room->is_admin			=$is_admin;
		
		// Si el valor es -1 agregamos todos los días al string
		if(in_array('-1',$request->days)){
			$days = '0,1,2,3,4,5,6';
		}else{
			$days = implode(',', $request->days);
		}
		$room->days             = $days;
		
		

		if($request->company_address){
			$room->company_address  = true;       
		}else{
			$room->company_address  = false;
			$room->address          = $request->address;
			$room->colony           = $request->colony;
			$room->deputation       = $request->deputation;
			$room->postal_code      = $request->postal_code;
			$room->city             = $request->city;
		}
		if($is_admin){
			$room->save();
		}else{
			$company = Company::where('id',$company_id)->with('rooms')->first();      
			$company->rooms()->save($room);
		}
		
		
		// Creamos los objetos de imagen y los relacionamos con el cuarto
		$images = json_decode($request->input('images'),true);
		foreach ( $images as $image) {
		
			$newImage = new MediaItem();
			$newImage->name = $image['name'];
			$newImage->path = $image['path'];
			$newImage->room_id = $room->id;
			$newImage->save(); 
			 
		}

		// respondemos la petición con un true
		return response()->json(['success' => true,'is_admin',$is_admin]);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		// Declaramos las primeras variables
		$room = Room::find($id);
		$reservation_opt = false;
		if(!$room){
			return "Esta sala ha sido eliminada o está temporalmente suspendida";
		}

		if($room->company_address){
			$room['address']        = $room->companies->address;
			$room['colony']         = $room->companies->colony;
			$room['deputation']     = $room->companies->deputation;
			$room['postal_code']    = $room->companies->postal_code;
			$room['latitude']       = $room->companies->latitude;
			$room['longitude']      = $room->companies->longitude;
		}

		$room['equipment'] = explode(PHP_EOL, $room['equipment']);

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

		if(!Auth::guest()){
			$user 	 = Auth::user()->id;
		}else{
			$user = false;
		}

		$now                = Date::now();
        $room->promotions = $room->promotions->where('valid_ends', '>=',  $now)->where('status','published');;
        foreach ($room->promotions as $promotion) {
                
                $finishs = new Date($promotion->valid_ends);
                $finishs =  $finishs->format('l j F Y');

                if($promotion->rule == 'hours'){
                    $rules = " de descuento en la reserva de al menos ".$promotion->min_hours.' horas';
                }elseif ($promotion->rule == 'schedule') {
                    $days_array = ['Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'];
                    $days_valid = '';
                    $days = explode(',',$promotion->days);
                    foreach ($days as $key => $value) {

                        
                        if ($key === end($days)){
                            $days_valid .= $days_array[$value];
                        }else{
                            $days_valid .= $days_array[$value].', ';
                        }
                    }

                    $rules = ' en la reserva de tu ensayo entre las '.$promotion->schedule_starts.':00hrs. y las '.$promotion->schedule_ends.':00hrs. los días '.$days_valid;
                }

                if($promotion->type == 'direct'){
                    $description = '$'.$promotion->value.' de descuento '.$rules;
                }elseif ($promotion->type == 'percentage'){
                    $description = $promotion->value.'% de descuento'.$rules;
                }elseif ($promotion->type == 'hour_price'){
                    $description = '$'.$promotion->value.' precio por hora '.$rules;
                }
                $description = $description." válida hasta el ".$finishs;
                $promotion->description = $description;
        }

        if($room->companies->status == 'active' and $room->companies->reservation_opt){
        	$reservation_opt = true;
        }
        
        $comments = $room->comments;
        

        foreach ($comments as $comment) {
        	$role  	 =  $comment->users->roles->first()->name;

        	if($role == 'company' and $comment->users->companies->count() > 0){
        		$company = $comment->users->companies->first()->name;
        		$comment['author'] = $company;
        	}else{
        		$comment['author'] = $comment->users->name . ' '. $comment->users->lastname;
        	}

        }

        $days = explode(',',$room->days);
        $days_array = ['Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'];


		return view('reyapp.rooms.single')->with('room',$room)->with('user',$user)->with('reservation_opt',$reservation_opt)->with('days',$days)->with('days_array',$days_array);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{

		$user_id = Auth::user()->id;
		$room = Room::with('companies')->findOrFail($id);
		$room_user = $room->companies->users->first()->id;
		$role = User::find($user_id)->roles->first()->name;

		$types = Type::all();

		// verificamos que el usuario sea dueño de la información
		if($user_id != $room_user and $role!='admin'){
			return response()->json(['success' => false,'messages'=>'No tienes privilegios necesarios']); 
		}

		
		$company = $room->companies;
		
		$room['equipment'] = htmlspecialchars($room->equipment);
		$room['days'] = explode(',',$room->days);

		if($room->company_address){
			$latitude = $room->companies->latitude;
			$longitude = $room->companies->longitude;
		}else{
			$latitude = $room->latitude;
			$longitude = $room->longitude;
		}
		
		return view('reyapp.rooms.settings')->with('room',$room)->with('company',$company)->with('latitude',$latitude)->with('longitude',$longitude)->with('role',$role)->with('types',$types);
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
		// Registramos las reglas de validación
		$rules = array(
			'name'              => 'required|max:255',
			'description'       => 'required|max:255',
			'equipment'         => 'required|max:1000',
			'instructions'      => 'max:255',
			'days'              => 'required|max:255',
			'schedule_start'    => 'required|max:3', 
			'schedule_end'      => 'required|max:3',
			'color'             => 'required|max:10',        
			'price'             => 'required|integer',
			'status'            => 'in:inactive,active,deleted'        
		);

		// Validamos todos los campos
		$validator = Validator::make($request->all(), $rules);

		// Si la validación falla, nos detenemos y mandamos false
		if ($validator->fails()) {
			return response()->json(['success' => false,'message'=>'Hay campos con información inválida, por favor revísalos']);
		}
		 
		$room                   = Room::find($id);
		$room->name             = $request->name;
		$room->price            = $request->price;
		$room->description      = $request->description;
		$room->equipment        = $request->equipment;
		$room->instructions     = $request->instructions;
		$room->schedule_start   = $request->schedule_start;
		$room->schedule_end     = $request->schedule_end;
		$room->color            = $request->color;
		$days                   = implode(',', $request->days);
		$room->days             = $days;
		$room->status           = $request->status;
		$room->type_id          = $request->type;
		

		if($request->company_address){
			$room->company_address  = true;       
		}else{
			$room->company_address  = false;
			$room->address          = $request->address;
			$room->colony           = $request->colony;
			$room->deputation       = $request->deputation;
			$room->postal_code      = $request->postal_code;
			$room->city             = $request->city;
		}

			  
		$room->save();
		
		// Creamos los objetos de imagen y los relacionamos con el cuarto
		$images = json_decode($request->input('images'),true);
		foreach ( $images as $image) {
		
			$newImage = new MediaItem();
			$newImage->name = $image['name'];
			$newImage->path = $image['path'];
			$newImage->room_id = $room->id;
			$newImage->save(); 
			 
		}

		// respondemos la petición con un true
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
		$room = Room::find($id);
		$room->delete();

		return response()->json(['success' => true,'message'=>'EL item fue borrado con éxito']);
	}

	private function get_role(){
		if(!Auth::guest()){
			$user = Auth::user();
			$role = $user->roles->first()->name;
			return $role;  
		}
	}

	public function rooms_admin()
	{	

		if($this->get_role() == 'admin'){
			$rooms = Room::where('is_admin', 1)->get();

			foreach ($rooms as $room) {
				// Cuantificamos y promediamos las calificaiones
				$quality = 0;
				$sumRatings = count($room->ratings);

				if($sumRatings > 0){
					foreach ($room->ratings as $rating) {
						$quality += $rating->score;
					}

					$quality = $quality / $sumRatings;
					$room['score']    = $quality;
				}
				
				$room['ratings'] = $sumRatings;
			}



			return view('reyapp.admin.rooms_admin')->with('rooms',$rooms)->with('role',$this->get_role());
		}else{
			return false;
		}
		
	}


	
}
