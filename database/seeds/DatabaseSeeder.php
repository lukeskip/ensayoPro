<?php

use Illuminate\Database\Seeder;
use App\User as User;
use App\Role;
use App\Setting as Setting;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

    	

    	$admin_token = str_random(60);
    	$musician_token = str_random(60);
    	$company_token = str_random(60);
        // check if table users is empty
		if(DB::table('roles')->get()->count() == 0){

			DB::table('roles')->insert([

				[
					'name' => 'admin',
					'token' => $admin_token,
				],
				[
					'name' => 'company',
					'token' => $company_token,
				],
				[
					'name' => 'musician',
					'token' => $musician_token,
				]

			]);

			$role 			= Role::where('token',$admin_token)->first();
			$role_musician  = Role::where('token',$musician_token)->first();
			$role_company   = Role::where('token',$company_token)->first();

			// Creamos el usuario admin
			$user = new User;
			$user->name = 'Sergio';
			$user->lastname = 'García';
			$user->email = 'admin@correo.com';
			$user->phone = '5555555555';
			$user->password = bcrypt('secret');
			$user->active_token = str_random(60);
			$user->active = true;
			$user->save();
			$user->roles()->attach($role->id);

			// Creamos el usuario Músico
			$user = new User;
			$user->name = 'Humberto';
			$user->lastname = 'Barba';
			$user->email = 'company@correo.com';
			$user->phone = '5555555555';
			$user->password = bcrypt('secret');
			$user->active_token = str_random(60);
			$user->active = true;
			$user->save();
			$user->roles()->attach($role_company->id);

			// Creamos el usuario compañia 1
			$user = new User;
			$user->name = 'Humberto';
			$user->lastname = 'Barba';
			$user->email = 'company_2@correo.com';
			$user->phone = '5555555555';
			$user->password = bcrypt('secret');
			$user->active_token = str_random(60);
			$user->active = true;
			$user->save();
			$user->roles()->attach($role_company->id);

			// Creamos el usuario compañía 2
			$user = new User;
			$user->name = 'Carlos';
			$user->lastname = 'Barba';
			$user->email = 'musician@correo.com';
			$user->phone = '5555555555';
			$user->password = bcrypt('secret');
			$user->active_token = str_random(60);
			$user->active = true;
			$user->save();
			$user->roles()->attach($role_musician->id);

			// Creamos el setting commission
			$setting = new Setting;
			$setting->type = 'number';
			$setting->label = 'Comisión';
			$setting->slug = 'comission';
			$setting->description = 'Es la comisión que cobrarás por cada reservación se escribe en decimales';
			$setting->value = '.10';
			$setting->save();

			// Creamos el setting client_commission 
			$setting = new Setting;
			$setting->type = 'number';
			$setting->label = 'Comisión cliente';
			$setting->slug = 'client_commission';
			$setting->description = 'Es la comisión que cobrarás al cliente por el total de su pago se escribe en decimales';
			$setting->value = '.025';
			$setting->save();

			// Creamos el setting cancel_time
			$setting = new Setting;
			$setting->type = 'number';
			$setting->label = 'Tiempo de cancelación';
			$setting->description = 'Es el tiempo que tendrá el usuario para poder cancelar su reservación se expresa en horas';
			$setting->slug = 'cancel_time';
			$setting->value = '48';
			$setting->save();


			// Creamos el setting max_oxxo
			$setting = new Setting;
			$setting->type = 'number';
			$setting->label = 'Máximo de horas Oxxo';
			$setting->description = 'Es el máximo de horas que un usuario puede reservar vía oxxo';
			$setting->slug = 'max_oxxo';
			$setting->value = '6';
			$setting->save();

			// Creamos el setting max_card
			$setting = new Setting;
			$setting->type = 'number';
			$setting->label = 'Máximo de horas Tarjeta';
			$setting->description = 'Es el máximo de horas que un usuario puede reservar vía tarjeta de crédito o débito';
			$setting->slug = 'max_card';
			$setting->value = '15';
			$setting->save();

			// Creamos el setting min_available_oxxo
			$setting = new Setting;
			$setting->type = 'number';
			$setting->label = 'Mínimo de anticipación para pagos oxxo';
			$setting->description = 'Es el mínimo de horas de anticipación para que un usuario pueda ocupar el pago con oxxo';
			$setting->slug = 'min_available_oxxo';
			$setting->value = '24';
			$setting->save();

			// Creamos el setting max_log_hours
			$setting = new Setting;
			$setting->type = 'number';
			$setting->label = 'Compañía tiempo sin logeo antes de pausa';
			$setting->description = 'Máximo de horas que una compañía puede estar sin logearse';
			$setting->slug = 'max_log_hours';
			$setting->value = '24';
			$setting->save();


			

			

			factory(App\Room::class, 5)->create();

			factory(App\Company::class, 1)->create()->each(function ($u) {
        		$u->users()->attach(2);
    		});

			// factory(App\Reservation::class, 100)->create([
			// 	'user_id' => 2
			// ]);

			factory(App\Comment::class, 50)->create();

			factory(App\Rating::class, 50)->create();

			



    		

		} else { echo "\e[31mTable is not empty, therefore NOT "; }

		
   
    }
}
