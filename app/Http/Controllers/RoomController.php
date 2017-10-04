<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as Auth;
use App\Room as Room;
use App\User as User;
use App\Company as Company;
use App\MediaItem as MediaItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items_per_page = 10;
        $order = 'quality_up';

        // Actuamos dependiento los filtros que tengamos diponibles
        if(request()->has('order')){
            
            if(request()->order == 'price_up'){
            
                $order = 'price';
                $rooms = Room::where('status','active')->orderBy($order, 'asc')->paginate($items_per_page);
            
            }else if(request()->order == 'price_down'){
            
                $order = 'price';
                $rooms = Room::where('status','active')->orderBy($order, 'desc')->paginate($items_per_page);
            
            }else if(request()->order == 'quality_up'){

                $rooms = Room::where('status','active')->leftJoin('opinions', 'opinions.room_id', '=', 'rooms.id')->select('rooms.*', DB::raw('AVG(score) as average' ))->groupBy('rooms.id')->orderBy('average', 'ASC')->paginate($items_per_page);

            }else if(request()->order == 'quality_down'){

                $rooms = Room::where('status','active')->leftJoin('opinions', 'opinions.room_id', '=', 'rooms.id')->select('rooms.*', DB::raw('AVG(score) as average' ))->groupBy('rooms.id')->orderBy('average', 'DESC')->paginate($items_per_page);
            }

        }else{
            
            $rooms = Room::where('status','active')->paginate($items_per_page);

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
            
            // Cuantificamos y promediamos las opiniones en base 5
            $quality = 0;
            $sumOpinions = count($room->opinions);

            if($sumOpinions > 0){
                foreach ($room->opinions as $opinion) {
                    $quality += $opinion->score;
                }

                $quality = $quality / $sumOpinions;
                $room['score']    = round(($quality *100) / 5);
            }
            
            $room['opinions'] = $sumOpinions;
        }

        
        $companies = Company::orderBy('name', 'desc')->get();
        $order = request()->order;

        return view('reyapp.rooms.list')->with('rooms',$rooms)->with('companies',$companies)->with('order',$order);
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
        $companies = $companies->companies;
        return view('reyapp.rooms.register_room')->with('companies',$companies);
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
            'description'       => 'required|max:1000',
            'equipment'         => 'required|max:1000',
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
         
        $company_id             = $request->company;
        $room                   = new Room();
        $room->name             = $request->name;
        $room->price            = $request->price;
        $room->description      = $request->description;
        $room->equipment        = $request->equipment;
        $room->schedule_start   = $request->schedule_start;
        $room->schedule_end     = $request->schedule_end;
        $room->color            = $request->color;
        $room->status           = 'inactive';
        

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

        $company = Company::where('id',$company_id)->with('rooms')->first();      
        $company->rooms()->save($room);
        
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $room = Room::find($id);

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
        $sumOpinions = count($room->opinions);

        if($sumOpinions > 0){
            foreach ($room->opinions as $opinion) {
                $quality += $opinion->score;
            }

            $quality = $quality / $sumOpinions;
            $room['score']    = round(($quality *100) / 5);
        }
        
        $room['opinions'] = $sumOpinions;
        

        return view('reyapp.rooms.single')->with('room',$room);
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
        $companies = User::where('id',$user_id)->with('companies')->first();
        $companies = $companies->companies;
        return view('reyapp.rooms.register_room')->with('companies',$companies);
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
