<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Company as Company;
use App\Setting as Setting;
use App\User as User;
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
