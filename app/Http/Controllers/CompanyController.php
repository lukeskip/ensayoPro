<?php

namespace App\Http\Controllers;

use App\Role as Role;
use App\Company as Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as Auth;
use App\User as User;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function register_user()
    {
        $role = Role::where('name','company')->first();
        return view('reyapp.register_user_company')->with('role',$role->token);
    }

    public function register_company()
    {    
        return view('reyapp.register_company');
    }

    public function index()
    {
        $companies = Company::all();
        return view('reyapp.companies')->with('companies',$companies);
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

        $user_id = Auth::user()->id;
        $company   = new Company();
        $company->name  = $request->name;
        $company->address = $request->address;
        $company->colony = $request->colony;
        $company->deputation = $request->deputation;
        $company->postal_code = $request->postal_code;
        $company->city = $request->city;
        $company->phone = $request->phone;
        $company->rfc = $request->rfc;
        $company->latitude = $request->latitude;
        $company->longitude = $request->longitude;
        $company->status = 'inactive';
        $user = User::findOrFail($user_id);
        $user->companies()->save($company);

        return redirect('registro/salas');

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
