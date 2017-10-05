<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as Auth;
use App\Opinion as Opinion;
use Illuminate\Support\Facades\Validator;

class OpinionController extends Controller
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
            'description'   => 'sometimes|nullable|max:1000',
            'score'         => 'required|integer',
            'room_id'       => 'required|integer',       
        );

        // Validamos todos los campos
        $validator = Validator::make($request->all(), $rules);

        $room_id        = $request->room_id;
        $score          = $request->score;
        $description    = $request->description;

        // Si la validación falla, nos detenemos y mandamos false
        if ($validator->fails()) {
            return response()->json(['success' => false,'message'=>'Hay campos con información inválida, por favor revísalos']);
        }

        $user_id = Auth::user()->id;
        $opinion_check = Opinion::where(
            function ($query) use ($room_id,$user_id) {
                $query->where('room_id', $room_id)->where('user_id', $user_id);
            })->first();

        
        if(!$opinion_check){
            $opinion = new Opinion;
            $opinion->description   = '$description';
            $opinion->score         = $score;
            $opinion->room_id       = $room_id;
            $opinion->user_id       = $user_id;
            $opinion->save();

            return response()->json(['success' => true,'message'=>'Gracias por calificar esta sala']);
        }else{

            $opinion_check->description = '$description';
            $opinion_check->score       = $score;

            $opinion_check->save();

            return response()->json(['success' => true,'message'=>'Gracias por calificar esta sala']);
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
