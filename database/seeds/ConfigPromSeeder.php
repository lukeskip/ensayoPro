<?php

use Illuminate\Database\Seeder;
use App\Setting as Setting;

class ConfigPromSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
		// Creamos el setting max_log_hours
		$setting = new Setting;
		$setting->type = 'number';
		$setting->label = 'Descuento máx. porcentaje';
		$setting->description = 'Es el máximo de porcentaje de descuento que se permite en las promociones';
		$setting->slug = 'max_prom_percentage';
		$setting->value = '50';
		$setting->save();

		// Creamos el setting max_prom_percentage
		$setting = new Setting;
		$setting->type = 'number';
		$setting->label = 'Descuento máx. directo';
		$setting->description = 'Es el máximo de descuento directo que se permite en las promociones';
		$setting->slug = 'max_prom_direct';
		$setting->value = '100';
		$setting->save();
    }
}
