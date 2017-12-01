<?php

use Carbon\Carbon;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Reservation::class, function (Faker\Generator $faker) {
	$starts = Carbon::createFromTimeStamp($faker->dateTimeBetween('this week', '+6 days')->getTimestamp());
    $ends  = $starts->addHours(2);
    return [
        'code' 			=> str_random(10),
        'starts' 		=> $starts,
        'ends' 			=> $ends,
        'description' 	=> $faker->realText(200),
        'price' 		=> $faker->randomElement(['200' ,'150', '120','100']),
        'is_admin' 		=> false,
        'code' 			=> str_random(10),
        'room_id'		=> rand(1,10),
        'status' 		=> $faker->randomElement(['confirmed' ,'pending', 'cancelled']),
    ];
});


$factory->define(App\Company::class, function (Faker\Generator $faker) {

    return [
        'name' 			=> $faker->company,
        'legalname' 	=> $faker->company,
        'address' 		=> $faker->address,
        'colony' 		=> $faker->state,
        'deputation' 	=> $faker->state,
        'postal_code' 	=> $faker->postcode,
        'city' 			=> $faker->city,
        'latitude' 		=> $faker->latitude(),
        'longitude' 	=> $faker->longitude(),
        'phone' 		=> $faker->phoneNumber,
        'rfc' 			=> str_random(10),
        'clabe' 		=> 31823741823746,
        'bank' 			=> $faker->company,
        'account_holder'=> $faker->name,
        'status' 		=> $faker->randomElement(['active' ,'inactive', 'deleted']),
        
    ];
});

$factory->define(App\Room::class, function (Faker\Generator $faker) {

    return [
        'name' 				=> 'Sala '.$faker->company,
        'company_address'	=> $faker->boolean,
        'color'				=> $faker->hexcolor,
        'description'		=> $faker->realText(200),
        'equipment'			=> $faker->realText(100),
        'days'				=> '0,1,2,3,4,5,6',
        'schedule_start'	=> 9,
        'schedule_end'		=> 23,
        'colony' 			=> $faker->state,
        'deputation' 		=> $faker->state,
        'postal_code' 		=> $faker->postcode,
        'city' 				=> $faker->city,
        'latitude' 			=> $faker->latitude(),
        'longitude' 		=> $faker->longitude(),
        'price' 			=> $faker->randomElement([100 ,150, 200]),
        'status' 			=> $faker->randomElement(['active']),
        'company_id' 		=> 1
        
    ];
});

$factory->define(App\Comment::class, function (Faker\Generator $faker) {
	
    return [
        'title' 			=> $faker->realText(30),
        'description' 		=> $faker->realText(200),
        'user_id' 			=> rand(1, 4),
        'room_id' 			=> rand(1, 5),
        'status' 			=> $faker->randomElement(['approved' ,'pending', 'rejected']),
    ];
});

$factory->define(App\Rating::class, function (Faker\Generator $faker) {
	
    return [
        'score' 			=> rand(1, 5),
        'user_id' 			=> rand(1, 4),
        'room_id' 			=> rand(1, 30),
    ];
});


