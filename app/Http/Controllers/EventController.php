<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth as Auth;
use App\Event as Event;

class EventController extends Controller
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
            'description'   => 'required|max:255',
            'start'         => 'required|date', 
            'end'           => 'required|date',       
        );

        // Validamos todos los campos
        $validator = Validator::make($request->all(), $rules);

        // Si la validación falla, nos detenemos y mandamos false
        if ($validator->fails()) {
            return response()->json(['success' => false,'message'=>'Hay campos con información inválida, por favor revísalos']);
        }

        $user_id        = Auth::user()->id;
        $description    = $request->description;
        $room_id        = $request->room_id;
        $starts         = $request->start;
        $ends           = $request->end;


        

        $event              = new Event();
        $event->description = $description;
        $event->starts      = $starts;
        $event->ends        = $ends;
        $event->user_id     = $user_id;
        
        if($request->has('band_id')){
          $event->band_id     = $request->band_id;  
        }
        

        $event->save();

        if ($request->has('band')) {
            $band = Band::find($request->band);
            $reservation->attach($band);
        }
        
        return response()->json(['success' => true , 'title' => $description,'id'=>$event->id]);
        
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
        $user_id = Auth::user()->id;
        $event = Event::find($id);
        if($user_id == $event->user_id);{
            $event->delete();
        }
        return response()->json(['success' => true]);
    }
}
