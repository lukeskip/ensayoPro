<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('logout', function (){
	Auth::logout();
	return redirect('/');
});

Route::get('/', function () {
    return view('reyapp.main');
});

Route::get('/registro', function () {
    return view('reyapp.register');
});

Route::group(['middleware' => 'auth'], function () {

	// STARTS: Carga de imágenes fineuploader
	Route::get('imagenes/{image}', function($image){

	    //do so other checks here if you wish
	    if(!File::exists( $image = storage_path("uploader/completed/{$image}") )) abort(401);

	    $returnImage = Image::make($image);

		return $returnImage->response();
	});
	// ENDS: Carga de imágenes fineuploader

	Route::get('salas/reservando/{room_id}', 'ReservationController@make_reservation');
	Route::post('salas/reservando/checkout', 'ReservationController@checkout');

	// Company Admin routes//////////////////////////////////////////////////////////
	Route::get('/company/dashboard', 'AdminCompanyController@company');
	Route::get('/company/salas', 'AdminCompanyController@company_rooms');

	Route::get('/company/codigos', 'AdminCompanyController@company_rooms');

	
	Route::get('/company/dashboard/calendar', 'AdminCompanyController@company_calendar');
	Route::get('/registro/company', 'CompanyController@register_company')->name('register_company');

	Route::get('/registro/salas', 'RoomController@create')->name('register_room');
	Route::get('/company/salas/editar/{id}', 'RoomController@edit');
	Route::post('/company/salas/{id}','RoomController@update');
	
	Route::resource('companies', 'CompanyController');


	// Dashboard routes//////////////////////////////////////////////////////////
	
	Route::get('/dashboard', 'DashboardController@musician')->name('dashboardMusician');
	
	Route::get('/admin/dashboard', 'DashboardController@admin')->name('dashboardAdmin');

	

	// ENDS: dashboard routes////////////////////////////////////////////////////

	
	
	// Redirigimos según role después de registro
	Route::get('registro/redirect', function (){
	$user_id = Auth::user()->id;
	$user = App\User::where('id', $user_id)->with('roles')->first();
	$role = $user->roles->first()->name;
	
		if($role == 'admin'){
			return redirect('admin/dashboard');
		}

		if($role == 'company'){
			return redirect('registro/company');
		}

		if($role == 'musician'){
			return redirect('/dashboard');
		}
	});


	//ENDS: Redirigimos según role después de registro


	// Redirigimos según role después de login
	Route::get('login/redirect', function (){
	$user_id = Auth::user()->id;
	$user = App\User::where('id', $user_id)->with('roles')->first();
	$role = $user->roles->first()->name;
	
		if($role == 'admin'){
			return redirect('admin/dashboard');
		}

		if($role == 'company'){
			return redirect('company/dashboard');
		}

		if($role == 'musician'){
			return redirect('/dashboard');
		}
	});

	//ENDS: Redirigimos según role después de login

	//STARTS: resources///////////////////////////////////////////// 
	Route::resource('bandas', 'BandController');
	
	Route::resource('opiniones', 'OpinionController');
	Route::resource('salas', 'RoomController');
	Route::resource('reservaciones', 'ReservationController');
	//ENDS: resources/////////////////////////////////////////////

	Route::get('/registro/banda', function () {
		return view('reyapp.register_band');
	});

	


	//STARTS: UPLOADER/////////////////////////////////////////////////////////
    Route::post('/uploader/upload', '\Optimus\FineuploaderServer\Controller\LaravelController@upload');
	Route::delete('/uploader/delete','\Optimus\FineuploaderServer\Controller\LaravelController@delete');
	Route::get('/uploader/session', '\Optimus\FineuploaderServer\Controller\LaravelController@session');

    // ENDS: UPLOADER///////////////////////////////////////////////////////////


});






Route::get('/home', 'HomeController@index')->name('home');
Route::get('/registro/usuario/company', 'CompanyController@register_user')->name('register_user_company');



