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

Route::get('/redirect', function (){
	$user  = App\User::find(Auth::user()->id);
	return $user;
	// if (in_array('admin', $roles)){
	// 	return redirect('/home');
	// }
});


Auth::routes();

Route::get('/registro', function () {
    return view('reyapp.register');
});

Route::resource('bandas', 'BandController');

Route::get('/registro/banda', function () {
	
	if(Auth::user())
	{
		return view('reyapp.register_band');
	}else{
		return redirect('/registro');
	}
    
});

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/registro/company', 'CompanyController@register')->name('register_company');



Route::get('/developers', 'DeveloperController@index')->name('home');
