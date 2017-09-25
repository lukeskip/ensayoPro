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

Route::get('logout', function (){
	Auth::logout();
	return redirect('/');
});

Route::get('/', function () {
    return view('reyapp.main');
});


Auth::routes();

Route::get('/registro', function () {
    return view('reyapp.register');
});

Route::get('/', function () {
    return view('reyapp.login');
});



Route::group(['middleware' => 'auth'], function () {

	Route::get('/reservaciones', 'ReservationController@index')->name('reservations');

	// Dashboard routes
	// Route::get('/dashboard', function () {
	//     return view('reyapp.dashboard');
	// });

	Route::get('/dashboard', 'ReservationController@index')->name('dashboard');

	Route::get('/company/dashboard', function () {
	    return view('reyapp.dashboard_company');
	});

	Route::get('/admin/dashboard', function () {
	    return view('reyapp.dashboard_admin');
	});
	// ENDS: dashboard routes

	Route::get('/registro/company', 'CompanyController@register_company')->name('register_company');
	
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

	Route::resource('bandas', 'BandController');

	Route::resource('companies', 'CompanyController');
	Route::resource('rooms', 'RoomController');

	Route::get('/registro/banda', function () {
		
		if(Auth::user())
		{
			return view('reyapp.register_band');
		}else{
			return redirect('/registro');
		}
	    
	});

	// Route::get('/registro/salas', function () {
 //    	return view('reyapp.register_room');
	// });

	Route::get('/registro/salas', 'RoomController@register')->name('register_room');


	//STARTS: UPLOADER
    Route::post('/uploader/upload', '\Optimus\FineuploaderServer\Controller\LaravelController@upload');
	Route::delete('/uploader/delete','\Optimus\FineuploaderServer\Controller\LaravelController@delete');
	Route::get('/uploader/session', '\Optimus\FineuploaderServer\Controller\LaravelController@session');

    // ENDS: UPLOADER
});






Route::get('/home', 'HomeController@index')->name('home');
Route::get('/registro/usuario/company', 'CompanyController@register_user')->name('register_user_company');



