<?php

use Illuminate\Database\Seeder;
use App\User as User;
use App\Role;

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
        // check if table users is empty
		if(DB::table('roles')->get()->count() == 0){

			DB::table('roles')->insert([

				[
					'name' => 'admin',
					'token' => $admin_token,
				],
				[
					'name' => 'company',
					'token' => str_random(60),
				],
				[
					'name' => 'musician',
					'token' => str_random(60),
				]

			]);

			// Creamos el usuario admin
			$user = new User;
			$user->name = 'Sergio';
			$user->lastname = 'García';
			$user->email = 'contacto@chekogarcia.com.mx';
			$user->password = bcrypt('Futurama84!');
			$user->save();
			$role = Role::where('token',$admin_token)->first();
			$user->roles()->attach($role->id);

		} else { echo "\e[31mTable is not empty, therefore NOT "; }
   
    }
}
