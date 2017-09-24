<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as Auth;
use App\Room as Room;
use App\User as User;
use App\company as company;
use App\MediaItem as MediaItem;

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
        $company_id = $request->company;
        $room               = new Room();
        $room->name         = $request->name;
        $room->address      = $request->address;
        $room->price        = $request->price;
        $room->description  = $request->description;

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

        return response()->json(['success' => 'true']);
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
