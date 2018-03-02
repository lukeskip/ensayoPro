<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as Auth;
use App\Rating as Rating;
use Illuminate\Support\Facades\Validator;

class RatingController extends Controller
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
        if(Auth::check()){
        
            // Registramos las reglas de validación
            $rules = array(
                'score'         => 'required|integer',
                'room_id'       => 'required|integer',       
            );

            // Validamos todos los campos
            $validator = Validator::make($request->all(), $rules);

            $room_id        = $request->room_id;
            $score          = $request->score;

            // Si la validación falla, nos detenemos y mandamos false
            if ($validator->fails()) {
                return response()->json(['success' => false,'message'=>'Hay campos con información inválida, por favor revísalos']);
            }

            $user_id = Auth::user()->id;

            $rating_check = Rating::where('room_id',$room_id)->where('user_id',$user_id)->first();

            // Revisamos si el usuario ya había calificato esta sala 
            if(!$rating_check){
                $rating = new Rating;
                $rating->score         = $score;
                $rating->room_id       = $room_id;
                $rating->user_id       = $user_id;
                $rating->save();

                return response()->json(['success' => true,'message'=>'Gracias por calificar esta sala']);
            // Si si la actualizamos 
            }else{

                $rating_check->score       = $score;
                $rating_check->save();

                return response()->json(['success' => true,'message'=>'Gracias por calificar esta sala']);
            }
        }else{
           return response()->json(['success' => false,'login'=>false,'message'=>'logéate para poder calificar esta sala']); 
        }
        
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
