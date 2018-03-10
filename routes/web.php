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

Route::get('/confirmacion/{order_id}','PaymentController@show');
// Route::get('/aplicar_type','TypeController@change_rooms_type');
// Route::get('/payments', 'PaymentController@index');
// Route::post('/checkout', 'PaymentController@checkout');

Route::post('/card', 'PaymentController@CreatePayCard');
Route::post('/oxxo', 'PaymentController@CreatePayOxxo');

Route::get('logout', function (){
	Auth::logout();
	return redirect('/login');
});

// rutas para loggeo con facebook
Route::get('/redirect', 'SocialAuthFacebookController@redirect');
Route::get('/callback', 'SocialAuthFacebookController@callback');

// Landing Músicos
Route::get('/', function () {
    return view('reyapp.main');
});

Route::get('/phpinfo', function () {
    return phpinfo();
});

// Route::get('/eliminar_calificaciones', 'RatingController@eliminar_calificaciones');

Route::get('/generar_reporte', 'ReportController@store');

Route::get('/terminos_y_condiciones', function(){
	return view('reyapp.mandatories.terms');
});

Route::get('/aviso-de-privacidad', function(){
	return view('reyapp.mandatories.privacy');
});

// Landing Company
Route::get('/unete', function () {
    return view('reyapp.landing_company');
});

Route::get('/registro', function () {
	if(Auth::guest()){
		return view('reyapp.register');	
	}else{
		return redirect('login/redirect');
	}
    
});

Route::post('/confirmed_oxxo','PaymentController@confirmation');
// Route::get('/confirmed','PaymentController@confirm_test');

Route::get('/registro/usuario/company', 'CompanyController@register_user')->name('register_user_company');

Route::get('/finaliza_tu_registro/{token}', 'UserController@finish_register');


Route::group(['middleware' => ['auth','company','active'],'prefix'=>'company'], function () {

	Route::get('/promocodigos/', 'PromocodeController@create');

	Route::get('/agenda/', 'AdminCompanyController@company_calendar');

	Route::get('/', 'AdminCompanyController@company')->name('dashboard_company');
	Route::get('/salas', 'AdminCompanyController@company_rooms');
	Route::get('/codigos', 'AdminCompanyController@company_rooms');
	
	Route::get('/ajustes/', 'CompanyController@edit');
	Route::get('/datalle/{id}', 'CompanyController@show');

	Route::get('/promociones/', 'PromotionController@index_company');
	Route::get('/promociones/registro', 'PromotionController@create');
	Route::post('/promociones/registro', 'PromotionController@store');
	Route::get('/promociones/{id}', 'PromotionController@edit');
	Route::post('/promociones/{id}', 'PromotionController@update');
	
	Route::get('/registro', 'CompanyController@register_company')->name('register_company');
	Route::resource('companies', 'CompanyController');
	Route::delete('/borrar_imagen/{id}', 'RoomController@delete_image');

	// Registro y ajustes de sala sólo para usuarios "company"
	Route::get('/registro/salas', 'RoomController@create')->name('register_room');
	Route::get('/salas/ajustes/{id}', 'RoomController@edit');
	Route::post('/salas','RoomController@store');
	Route::get('/salas','RoomController@index_company');
	Route::put('/salas/{id}','RoomController@update');
	Route::get('/reportes','ReportController@index_company');
	Route::get('/reportes/{id}','ReportController@show');
	
});

Route::group(['middleware' => ['auth','admin','active'],'prefix'=>'admin'], function () {
	Route::get('/', 'AdminController@index')->name('admin');
	Route::put('/comentarios/{id}', 'CommentController@update')->name('admin');
	Route::get('/comentarios/', 'CommentController@index')->name('admin');
	Route::get('/salas/ajustes/{id}', 'RoomController@edit');
	Route::get('/salas/', 'RoomController@index');
	Route::get('/pagos/', 'PaymentController@index');
	Route::get('/pagos/{order_id}/', 'PaymentController@show');
	Route::get('/ajustes/', 'AdminController@settings');
	Route::put('/settings_save/', 'AdminController@settings_save');

	Route::get('/companies/', 'CompanyController@index');
	Route::get('/company/ajustes/{id}', 'CompanyController@edit_admin');

	Route::get('/users/', 'AdminController@users');
	Route::get('/reportes/', 'ReportController@index');
	Route::get('/reservaciones/', 'ReservationController@index');
	Route::get('/reportes/{id}','ReportController@show');
});


Route::group(['middleware' => ['auth','musician','active'],'prefix'=>'musico'], function () {
	Route::get('/agenda', 'AdminMusicianController@calendar')->name('admin');
	Route::resource('eventos', 'EventController');
	Route::get('/bienvenido', 'AdminMusicianController@dashboard');

	Route::get('/bandas', 'BandController@index');
	Route::post('/bandas', 'BandController@store');
	Route::get('/bandas/{id}', 'BandController@edit');
	Route::put('/bandas/{id}', 'BandController@update');
	Route::put('/bandas_delete_member/', 'BandController@delete_member');

	Route::put('/reservaciones/{id}', 'ReservationController@cancel');
	
	Route::post('/checkprice', 'ReservationController@checkprice');
});

Route::group(['middleware' => ['auth']], function () {
	Route::get('/activa_tu_cuenta', 'UserController@active_form');
	Route::get('/activa_tu_cuenta/{token}', 'UserController@active');
	Route::get('/reenviar_bienvenida/', 'UserController@bienvenida');
	Route::resource('/usuarios', 'UserController');
});


Route::group(['middleware' => ['auth','active']], function () {

	Route::get('/salas/reservando/{room_id}', 'ReservationController@make_reservation');
	Route::post('/salas/reservando/confirmacion', 'ReservationController@checkout');

	Route::get('/salas/reservacion/edicion/{code}', 'ReservationController@edit');
	Route::put('/salas/reservacion/edicion/{code}', 'ReservationController@update');
	

	

	// ENDS: dashboard routes////////////////////////////////////////////////////

	
	
	// Redirigimos según role después de registro
	Route::get('/registro/redirect', function (){

		$user_id = Auth::user()->id;
		$user = App\User::where('id', $user_id)->with('roles')->first();
		$role = $user->roles->first()->name;
	
		if($role == 'admin'){
			return redirect('/admin');
		}

		if($role == 'company'){
			return redirect('/company/registro');
		}

		if($role == 'musician'){
			return redirect('/registro/banda');
		}
	});


	//ENDS: Redirigimos según role después de registro


	// Redirigimos según role después de login
	Route::get('login/redirect', function (){
	$user_id = Auth::user()->id;
	$user = App\User::where('id', $user_id)->with('roles')->first();
	$role = $user->roles->first()->name;
	
		if($role == 'admin'){
			return redirect('/admin');
		}

		if($role == 'company'){
			return redirect('/company');
		}

		if($role == 'musician'){
			return redirect('/salas');
		}
	});

	//ENDS: Redirigimos según role después de login

	//STARTS: resources///////////////////////////////////////////// 
	// Route::resource('bandas', 'BandController');
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



Route::resource('comentarios', 'CommentController');
Route::resource('ratings', 'RatingController');

// Rutas de salas sin necesidad de registro
Route::get('/salas/{id}', 'RoomController@show');
Route::get('/salas', 'RoomController@index');
Route::get('/estudios-de-grabacion', 'RoomController@index_studios');

// STARTS: Carga de imágenes fineuploader
Route::get('imagenes/{image}', function($image){

    //do so other checks here if you wish
    if(!File::exists( $image = storage_path("uploader/completed/{$image}") )) abort(401);

    $returnImage = Image::make($image);

	return $returnImage->response();
});
// ENDS: Carga de imágenes fineuploader


	Route::get('/mail_test', function () {
		return view('reyapp.reminder');
	});




// Route::get('/home', 'HomeController@index')->name('home');




