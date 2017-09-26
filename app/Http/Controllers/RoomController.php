<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as Auth;
use App\Room as Room;
use App\User as User;
use App\Company as Company;
use App\MediaItem as MediaItem;
use Illuminate\Support\Facades\DB;

class RoomController extends Controller
{
    
    public function register (){
        $user_id = Auth::user()->id;
        $companies = User::where('id',$user_id)->with('companies')->first();
        $companies = $companies->companies;
        return view('reyapp.register_room')->with('companies',$companies);
    }


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
                $rooms = Room::orderBy($order, 'asc')->paginate($items_per_page);
            
            }else if(request()->order == 'price_down'){
            
                $order = 'price';
                $rooms = Room::orderBy($order, 'desc')->paginate($items_per_page);
            
            }else if(request()->order == 'quality_up'){

                $rooms = Room::leftJoin('opinions', 'opinions.room_id', '=', 'rooms.id')->select('rooms.*', DB::raw('AVG(score) as average' ))->groupBy('rooms.id')->orderBy('average', 'ASC')->paginate($items_per_page);

            }else if(request()->order == 'quality_down'){

                $rooms = Room::leftJoin('opinions', 'opinions.room_id', '=', 'rooms.id')->select('rooms.*', DB::raw('AVG(score) as average' ))->groupBy('rooms.id')->orderBy('average', 'DESC')->paginate($items_per_page);
            }

        }else{
            
            $rooms = Room::paginate($items_per_page);

        }
        

        // Si tienen la misma dirección de la compañía la asignamos y la mandamos dentro del mismo objeto
        
        foreach ($rooms as $room) {

            if($room->company_address){
                $room['address']        = $room->companies->address;
                $room['colony']         = $room->companies->colony;
                $room['deputation']     = $room->companies->deputation;
                $room['postal_code']    = $room->companies->postal_code;
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
        $company_id = $request->company;
        $room                   = new Room();
        $room->name             = $request->name;
        $room->price            = $request->price;
        $room->description      = $request->description;
        

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
