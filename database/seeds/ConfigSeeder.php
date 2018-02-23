<?php

use Illuminate\Database\Seeder;
use App\Setting as Setting;

class ConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
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

		// Creamos el setting max_log_hours
		$setting = new Setting;
		$setting->type = 'number';
		$setting->label = 'Comision por servicio';
		$setting->description = 'Es la comisión que se le cobra al usuario por el uso de la plataforma';
		$setting->slug = 'user_comission';
		$setting->value = '6';
		$setting->save();

		// Creamos el setting max_log_hours
		$setting = new Setting;
		$setting->type = 'number';
		$setting->label = 'Caducidad Oxxo';
		$setting->description = 'Es el tiempo que tiene un usuario para pagar el importe marcado vía oxxo, por tanto también es el tiempo de caducidad de código de referencia';
		$setting->slug = 'expiration_oxxo';
		$setting->value = '12';
		$setting->save();

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

		// Creamos el setting statement_date
		$setting = new Setting;
		$setting->type = 'select';
		$setting->label = 'Día de Corte';
		$setting->labels = 'Domingo,Lunes,Martes,Miércoles,Jueves,Viernes,Sábado';
		$setting->options = 'sunday,monday,tuesday,wednesday,thursday,friday,saturday';
		$setting->description = 'Es el día de la semana en el que se hace el corte de pagos';
		$setting->slug = 'statement_date';
		$setting->value = 'tuesday';
		$setting->save();


    }
}
