<?php

use Illuminate\Database\Seeder;
use App\Type as Type;

class TypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Creamos el Type room
		$setting = new Type;
		$setting->name = 'room';
		$setting->label = 'Sala de ensayo';
		$setting->save();

		// Creamos el Type room
		$setting = new Type;
		$setting->name = 'studio';
		$setting->label = 'Estudio de grabación';
		$setting->save();

		// Creamos el Type room
		$setting = new Type;
		$setting->name = 'live_session';
		$setting->label = 'Live session';
		$setting->save();
    }
}
