<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Company as Company;
use App\Setting as Setting;
use App\User as User;
use App\Reservation as Reservation;
use Mail;
use Jenssegers\Date\Date;

class Kernel extends ConsoleKernel
{
	/**
	 * The Artisan commands provided by your application.
	 *
	 * @var array
	 */
	protected $commands = [
		//
	];

	/**
	 * Define the application's command schedule.
	 *
	 * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
	 * @return void
	 */
	protected function schedule(Schedule $schedule)
	{   

		$schedule->call(function () {
			$max_hours      = Setting::where('slug','max_log_hours')->first()->value;
			$now            = new Date();
			$limit          = $now->subHours($max_hours);
			$users          = User::where('last_login','<=',$limit)->with('companies')->get();
			foreach ($users as $user) {
				$email = $user->email;
				foreach ($user->companies as $company) {
					if($company->status == 'active'){
						$company->status = 'paused';
						$company->save();

						Mail::send('reyapp.mails.com_paused', ['max_hours'=>$max_hours], function ($message)use($email){

						$message->from('no_replay@ensayopro.com.mx', 'EnsayoPro')->subject('Tu compañía ha sido pausada');
						$message->to($email);

						});  
					}
					
				}
			}
			
		})->daily();

		$schedule->call(function () {
			$reservations = Reservation::where('status','pending')->where('starts', '>=', Date::today())->whereHas('payments', function ($query) {
				$query->where('status','pending_payment')->where('expires_at', '>', strtotime(Date::today()));
			})->get();


			//Mail para envio de pruebas,  
			// Mail::send('reyapp.mails.test_kernel', ['reservations'=>$reservations], function ($message){

			//     $message->from('no_replay@ensayopro.com.mx', 'EnsayoPro')->subject('Tienes una reservación en ');
			//     $message->to('contacto@chekogarcia.com.mx');

			// });

			foreach ($reservations as $reservation) {   
				$reservation->status = "cancelled";
				$reservation->save();


			}

		})->everyThirtyMinutes();

		$schedule->call(function () {

			$statement_date     = Setting::where('slug','statement_date')->first()->value;
			$today = new Date();
			$dow   = array('sunday','monday','tuesday','wednesday','thursday','friday','saturday');
			$today = $today->format('w');

			if($dow[$today] != $statement_date){
				return $dow[$today];
			}

			$day1               = Date::parse('last '.$statement_date)->startOfDay();
			$day2               = Date::parse('last '.$statement_date)->addWeeks(1)->endOfDay();
			$companies          = Company::all();
			$comission_setting  = Setting::where('slug','comission')->first()->value;
			
			foreach ($companies as $company) {
				
				$payments = Payment::where('company_id',$company->id)->whereBetween('created_at',[$day1,$day2])->where('status','paid')->get();
				
				$user_comissions    = 0;
				$company_comissions = 0;
				$company_incomings  = 0;
				$admin_incomings    = 0;
				$hours              = 0;
				$hours_prom         = 0;
				$period_starts      = $day1;
				$period_ends        = $day2;

			
				foreach ($payments as $payment) {
					$company_comission   = $payment->amount * $comission_setting;
					$user_comissions    += $payment->comission;
					$company_comissions += $company_comission;
					$company_incomings  += $payment->amount - $company_comission;
					$hours      += $payment->quantity;
					$hours_prom += $payment->quantity_prom;
					
				}

				$admin_incomings  = $user_comissions + $company_comissions;

				$report                     = new Report;
				$report->company_id         = $company->id;
				$report->user_comissions    = $user_comissions;
				$report->company_comissions = $company_comissions;
				$report->company_incomings  = $company_incomings;
				$report->admin_incomings    = $admin_incomings;
				$report->hours              = $hours;
				$report->hours_prom         = $hours_prom;
				$report->period_starts      = $period_starts;
				$report->period_ends        = $period_ends;
				$report->save();

			}

		})->daily();

	}

	/**
	 * Register the Closure based commands for the application.
	 *
	 * @return void
	 */
	protected function commands()
	{
		require base_path('routes/console.php');
	}
}
