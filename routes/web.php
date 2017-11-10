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
	return redirect('/login');
});

Route::get('/', function () {
    return view('reyapp.main');
});

Route::get('/registro', function () {
    return view('reyapp.register');
});

Route::group(['middleware' => ['auth','company'],'prefix'=>'company'], function () {
	Route::get('/', 'AdminCompanyController@company');
	Route::get('/salas', 'AdminCompanyController@company_rooms');
	Route::get('/codigos', 'AdminCompanyController@company_rooms');
	
	Route::get('/ajustes/{id}', 'CompanyController@edit');
	Route::get('/agenda', 'AdminCompanyController@company_calendar');
	Route::get('/registro', 'CompanyController@register_company')->name('register_company');
	Route::resource('companies', 'CompanyController');
	Route::delete('/borrar_imagen/{id}', 'RoomController@delete_image');

	// Registro y ajustes de sala sólo para usuarios "company"
	Route::get('/registro/salas', 'RoomController@create')->name('register_room');
	Route::get('/salas/ajustes/{id}', 'RoomController@edit');
	Route::post('/salas','RoomController@store');
	Route::get('/salas','RoomController@index_company');
	Route::put('/salas/{id}','RoomController@update');
	
});

Route::group(['middleware' => ['auth','admin'],'prefix'=>'admin'], function () {
	Route::get('/dashboard', 'DashboardController@admin')->name('dashboardAdmin');
});

Route::group(['middleware' => 'auth'], function () {

	Route::get('salas/reservando/{room_id}', 'ReservationController@make_reservation');
	Route::post('salas/reservando/checkout', 'ReservationController@checkout');

	
	Route::get('/dashboard', 'DashboardController@musician')->name('dashboardMusician');
	
	

	

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
			return redirect('company/registro');
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
			return redirect('admin/dashboard');
		}

		if($role == 'company'){
			return redirect('company');
		}

		if($role == 'musician'){
			return redirect('/dashboard');
		}
	});

	//ENDS: Redirigimos según role después de login

	//STARTS: resources///////////////////////////////////////////// 
	Route::resource('bandas', 'BandController');
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

Route::get('/payments', 'PaymentController@index');
Route::post('/checkout', 'PaymentController@checkout');

Route::resource('comentarios', 'CommentController');
Route::resource('ratings', 'RatingController');

// Rutas de salas sin necesidad de registro
Route::get('/salas/{id}', 'RoomController@show');
Route::get('/salas', 'RoomController@index');

// STARTS: Carga de imágenes fineuploader
Route::get('imagenes/{image}', function($image){

    //do so other checks here if you wish
    if(!File::exists( $image = storage_path("uploader/completed/{$image}") )) abort(401);

    $returnImage = Image::make($image);

	return $returnImage->response();
});
// ENDS: Carga de imágenes fineuploader






Route::get('/home', 'HomeController@index')->name('home');
Route::get('/registro/usuario/company', 'CompanyController@register_user')->name('register_user_company');



