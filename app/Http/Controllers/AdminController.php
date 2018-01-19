<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth as Auth;
use App\Room as Room;
use App\User as User;
use App\Company as Company;
use App\Comment as Comment;
use App\Setting as Setting;
use App\Payment as Payment;
use App\Reservation as Reservation;
use Date;


class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $day1 = Date::parse('last tuesday')->startOfDay();
        $day2 = Date::parse('next monday')->endOfDay();
        $reservations   = Reservation::where('is_admin',0)->limit(5)->get();
        $comments       = Comment::where('status','pending')->limit(5)->get();
        $payments = Payment::whereBetween('created_at',[$day1,$day2])->where('status','paid')->get();
        $comission = Setting::where('slug','comission')->first()->value;

        $incomings  = 0;
        $hours      = 0;

        //Sumamos los payments de la semana para obtener lo ingresos
        foreach ($payments as $payment) {
            $company_comission = $payment->amount * $comission;
            $incomings += $company_comission + $payment->comission;
        }

        //Sumamos las horas reservadas
        foreach ($reservations as $reservation) {
            $date_starts = new Date($reservation['starts']);
            $date_ends = new Date($reservation['ends']);
            if($reservation->status == 'confirmed'){
                $reservation['hours'] = $date_starts->diffInHours($date_ends);
                $hours += $reservation->hours;
            }
        }

        
        $rooms = Room::leftJoin('ratings', 'ratings.room_id', '=', 'rooms.id')->select('rooms.*', DB::raw('AVG(score) as average' ))->groupBy('rooms.id')->orderBy('average', 'DESC')->limit(10)->get();


        foreach ($rooms as $room) {

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

        
        return view('reyapp.admin.dashboard')->with('rooms',$rooms)->with('reservations',$reservations)->with('comments',$comments)->with('incomings',$incomings)->with('hours',$hours);

    }

    public function rooms(){
        $rooms = Room::leftJoin('ratings', 'ratings.room_id', '=', 'rooms.id')->select('rooms.*', DB::raw('AVG(score) as average' ))->groupBy('rooms.id')->orderBy('average', 'DESC')->paginate(10);

        return view('reyapp.admin.rooms')->with('rooms',$rooms);
    }

    public function settings()
    {
        $settings = Setting::all();
        return view('reyapp.admin.settings')->with('settings',$settings);
    }

    public function settings_save(Request $request)
    {
        // Registramos las reglas de validación
        
        foreach ($request->all() as $key => $value) {
            if($value != ''){
                $setting = Setting::where('slug',$key)->get()->first();
                $setting->value = $value;
                $setting->save();
            }else{
                return response()->json(['success' => false,'message'=>'Hay campos vacíos']);
            }
            
        }

        return response()->json(['success' => true,'message'=>'Los cambios fueron guardados']);
        



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
        //
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

    public function users(){
        $users = User::orderBy('name','ASC');
        if(request()->has('buscar')){
           $users->where('name', 'LIKE', '%' . request()->buscar . '%')->orWhere('email', 'LIKE', '%' . request()->buscar . '%');
        }
        $users = $users->paginate(15);
        return view('reyapp.admin.users')->with('users',$users);

    }


}
