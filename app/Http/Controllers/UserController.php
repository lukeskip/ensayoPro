<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as Auth;
use Illuminate\Support\Facades\Hash;
use App\User as User;
use Illuminate\Support\Facades\Validator;
use Mail;

class UserController extends Controller
{   

    public function finish_register ($token){
        $user = User::where('active_token',$token)->first();
        if(!$user->active){
            return view('reyapp.users.finish_register')->with('user',$user);
        }else{
            return redirect('/musico/bienvenido'); 
        }
        
    }

    public function bienvenida (){
        $user = Auth::user();
        $active = $user->active;
        if(!$active){
            $active_token = Auth::user()->active_token;
            $email = $user->email;
            Mail::send('reyapp.mails.welcome', ['token'=>$active_token,'email'=>$email], function ($message)use($email){

                    $message->from('no_replay@ensayopro.com.mx', 'EnsayoPro')->subject('Bienvenido a EnsayoPro');
                    $message->to($email);

            });

            return response()->json(['success' => true,'messages'=>'El correo fue reenviado correctamente']);
        }else{
            return response()->json(['success' => false,'messages'=>'Esta cuenta ya está activa']);
        }
        

        
    }
    // Mostramos el mensaje pidiendo que active su cuenta y que revise en su correo
    public function active_form()
    {
        $active = Auth::user()->active;
        $message = '';
        if(!$active){
            $message = 'Tu cuenta de correo no ha sido validada, si no encuentras nuestro correo de bienvenida, revisa tu bandeja de correos no deseados';
        }else{
            $message = 'Tu cuenta está activa, ya puedes navegar por la página';
        }

        return view('reyapp.users.active')->with('message',$message)->with('active',$active);
    }

    public function active($token)
    {
        $user = User::where('active_token',$token)->first();
        if($user){
            $user->active = true;
            $user->active_token = str_random(60);
            $user->save(); 
        }
        

        return redirect('/activa_tu_cuenta/');    
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
        $user_id = Auth::user()->id;
        $user    = User::find($user_id);
        $role    = $user->roles->first()->name;

        if($role == 'admin'){
            $user = User::find($id); 
        }else if($user_id != $id){

            return redirect('/usuarios/'.$user_id);
        }

        return view('reyapp.users.single')->with('user',$user)->with('role',$role);
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
        
        $user = User::find($id);
        $role = $user->roles->first()->name;

        // Registramos las reglas de validación
        $rules = array(
            'name'      => 'required|string|max:255',
            'lastname'  => 'required|string|max:255',
            'phone'     => 'required|string|max:255',
            'email'     => 'required|string|email|max:255|unique:users,email,'.$id,
            'password'  => 'nullable|min:6|confirmed',      
        );

        // Validamos todos los campos
        $validator = Validator::make($request->all(), $rules);

        // Si la validación falla, nos detenemos y mandamos false
        if ($validator->fails()) {
            return response()->json($validator->messages(), 200);
        }

        if($user->id != $id and $role !='admin'){
            return response()->json(['success' => false,'messages'=>'No tienes privilegios necesarios']);
        }



        
        $user ->name = $request->name;
        $user->lastname = $request->lastname;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->active = true;

        $user->save();
        
        return response()->json(['success' => true,'messages'=>'Los datos fueron actualizados']);
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
