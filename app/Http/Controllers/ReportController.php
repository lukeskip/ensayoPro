<?php

namespace App\Http\Controllers;

use App\Report;
use Illuminate\Http\Request;
use App\Company as Company;
use App\Payment as Payment;
use App\Setting as Setting;
use App\User as User;
use Jenssegers\Date\Date;
use DateTime;
use Illuminate\Support\Facades\Auth as Auth;


class ReportController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		
		$week_total = 0;
		$reports = Report::orderBy('period_starts','DESC');
		

		// aplicamos el filtro
		if(request()->has('semana')){
			$reports = $reports->where('period_starts',$request->semana)->orderBy('period_starts','DESC');		
		}

		$reports = $reports->paginate(10);

		foreach ($reports as $report) {
			$report['company'] = $report->companies->name;; 
		}

		// Hacemos las cuenta total
		if(request()->has('semana')){
			foreach ($reports as $report) {
				$week_total += $report->company_incomings;
			}	
		}

		$weeks = Report::orderBy('period_starts','DESC')->get();
		$weeks = $weeks->unique('period_starts')->values()->all();
		foreach ($weeks as $week) {
			$period_starts = new Date($week->period_starts);
			$period_starts = $period_starts->format('d-m-Y');
			$week['period_starts_label'] = $period_starts;
		}

		return view('reyapp.reports.list_admin')->with('reports',$reports)->with('weeks',$weeks)->with('week_total',$week_total);
	}

	public function index_company()
	{
		$user = Auth::user();
		$user_id = Auth::user()->id;
		$role = User::find($user_id)->roles->first()->name;
		$company = $user->companies->first(); 
		$company_id = $company->id;

		if(!$company->reservation_opt){
			return redirect('/company');
		}  

		$reports = Report::where('company_id',$company_id)->paginate();

		foreach ($reports as $report) {
			$period_starts 			 	= new Date($report->period_starts);
			$period_ends 			 	= new Date($report->period_ends);
			$report['period_starts']   	= $period_starts->format('d-m-Y');
			$report['period_ends'] 		= $period_ends->format('d-m-Y');

		}

		
		return view('reyapp.reports.list')->with('reports',$reports);
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
		$statement_date 	= Setting::where('slug','statement_date')->first()->value;
		$day1     			= Date::parse('last '.$statement_date)->startOfDay();
		$day2     			= Date::parse('last '.$statement_date)->addWeeks(1)->endOfDay();
		$companies  		= Company::all();
		$comission_setting 	= Setting::where('slug','comission')->first()->value;
		
		foreach ($companies as $company) {
			
			$payments = Payment::where('company_id',$company->id)->whereBetween('created_at',[$day1,$day2])->where('status','paid')->get();
			
			$user_comissions 	= 0;
			$company_comissions = 0;
			$company_incomings 	= 0;
			$admin_incomings 	= 0;
			$hours 				= 0;
			$hours_prom 		= 0;
			$period_starts 		= $day1;
			$period_ends 		= $day2;

		
			foreach ($payments as $payment) {
				$company_comission   = $payment->amount * $comission_setting;
				$user_comissions 	+= $payment->comission;
				$company_comissions += $company_comission;
				$company_incomings 	+= $payment->amount - $company_comission;
				$hours 		+= $payment->quantity;
				$hours_prom += $payment->quantity_prom;
				
			}

			$admin_incomings  = $user_comissions + $company_comissions;

			$report 					= new Report;
			$report->company_id 		= $company->id;
			$report->user_comissions 	= $user_comissions;
			$report->company_comissions = $company_comissions;
			$report->company_incomings  = $company_incomings;
			$report->admin_incomings 	= $admin_incomings;
			$report->hours 				= $hours;
			$report->hours_prom 		= $hours_prom;
			$report->period_starts 		= $period_starts;
			$report->period_ends 		= $period_ends;
			$report->save();

		}
		
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Report  $report
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		$user 		= Auth::user();
		$user 		= Auth::user();
		$user_id 	= Auth::user()->id;
		
		$role 		= User::find($user_id)->roles->first()->name;
		if($role == 'company'){
			$company_id = $user->companies->first()->id;
			 
		}
		
		$report 	= Report::find($id);
		$company 	= $report->companies->name;

		$period_starts 	= new Date($report->period_starts);
		$period_ends 	= new Date($report->period_ends);
		$report['period_starts'] = $period_starts->format('d-m-Y');
		$report['period_ends'] 	 = $period_ends->format('d-m-Y');


		$report['hours_total'] = $report->hours + $report->hours_prom;

		if($role == 'admin' or $report->company_id == $company_id){
			return view('reyapp.reports.single')->with('report',$report)->with('company',$company)->with('role',$role);
		}else{
			return redirect('/company');
		}


	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Report  $report
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Report $report)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Report  $report
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Report $report)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Report  $report
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Report $report)
	{
		//
	}
}
