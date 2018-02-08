<?php

namespace App\Http\Controllers;

use App\Promotion;
use Illuminate\Support\Facades\Auth as Auth;
use Illuminate\Http\Request;
use App\User as User;
use App\Room as Room;
use App\Setting as Setting;
use Illuminate\Support\Facades\Validator;
use Jenssegers\Date\Date;
use DateTime;

class PromotionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        if(!Auth::guest()){
            $user_id = $user->id;
            $role = User::find($user_id)->roles->first()->name;  
        }

        
        $companies = $user->companies()->with('promotions')->paginate();
        
        $promotions = $companies->promotions;
        
        foreach ($promotions as $promotion) {
            $now                = Date::now();
            $finishs            = new DateTime($promotion->valid_ends);
            $finishs            = $ends->diffInDays($now);
            $promotion['ends']  = $finishs;
        }

        return view('reyapp.companies.promotions')->with('promotions',$promotions);
    }

    public function index_company()
    {
        $user = Auth::user();

        if(!Auth::guest()){
            $user_id = $user->id;
            $role = $user->roles->first()->name;
            $company = $user->companies->first()->id;  
        }
   
        $promotions = Promotion::where('company_id',$company)->orderby('valid_ends','DESC')->paginate();

        foreach ($promotions as $promotion) {
            $now                = Date::now();
            $finishs            = new Date($promotion->valid_ends);
            if($now <= $finishs){
              $finishs            = $finishs->diffInDays($now);
              $promotion['finishs']  = 'Le quedan '.$finishs.' día(s)';  
            }else{
              $promotion['finishs']  = 'Esta promoción caducó';   
            }
            
            
        }
        
        return view('reyapp.companies.promotions')->with('promotions',$promotions);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();

        if(!Auth::guest()){
            $company = $user->companies->first();  
        }
        $settings               = Setting::all();
        $max_prom_percentage    = $settings->where('slug','max_prom_percentage')->first()->value;
        $max_prom_direct        = $settings->where('slug','max_prom_direct')->first()->value;

        $rooms      = $company->rooms;    
        return view('reyapp.promotions.register')->with('rooms',$rooms)->with('max_prom_direct',$max_prom_direct)->with('max_prom_percentage',$max_prom_percentage);
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
            'status'            => 'required',
            'type'              => 'required|in:direct,percentage',
            'rooms'             => 'required',
            'discount'          => 'required|integer',
            'valid_starts'      => 'required|date', 
            'valid_ends'        => 'required|date',
            'rule'              => 'required|in:schedule,hours',        
            'starts'            => 'date', 
            'min_hours'         => 'nullable|integer',        
        );

        $user    = Auth::user();
        $company = $user->companies->first(); 
        $status  = $request->status;
        $type    = $request->type;
        $value   = $request->discount;

        // Validamos todos los campos
        $validator = Validator::make($request->all(), $rules);

        // Si la validación falla, nos detenemos y mandamos false
        if ($validator->fails()) {
            return response()->json([$validator->messages(),'success'=>false], 200);
        }

        $promotion = new Promotion;
        $promotion->name            = $request->name;
        $promotion->status          = $status;
        $promotion->type            = $type;
        $promotion->company_id      = $company->id;
        $promotion->valid_starts    = $request->valid_starts;
        $promotion->valid_ends      = $request->valid_ends;
        $promotion->value           = $value;
        $promotion->rule            = $request->rule;

        if($type == 'direct'){
            $value = '$'.$value;
        }elseif ($type == 'percentage') {
            $value = $value.'%';
        }

        if($request->rule == 'hours'){

            $promotion->hours  = $request->hours;

        }else if($request->rule == 'schedule'){
            // Si el valor es -1 agregamos todos los días al string
            
            if(in_array('-1',$request->days)){
                $days    = '0,1,2,3,4,5,6';
            }else{
                $days    = implode(',', $request->days);
            }
            $promotion->days  = $days;

            $promotion->schedule_starts  = $request->schedule_starts;
            $promotion->schedule_ends    = $request->schedule_ends;
        }
        

        // Si el valor es -1 agregamos todas las salas del usuario
        if(in_array('-1',$request->rooms)){
            $rooms_ids = [];
            $rooms = Room::where('company_id',$company->id)->get();
        }else{
            $rooms  = Room::whereIn('id', $request->rooms)->get();
        }
        
        $promotion->save();

        foreach ($rooms as $room) {
            $promotion->rooms()->attach($room->id);
        }

        

        return response()->json(['success' => true,'message'=>'Se guardó correctamente']);


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function show(Offer $offer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function edit(Offer $offer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Offer $offer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Offer $offer)
    {
        //
    }
}
