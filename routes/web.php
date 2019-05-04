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

// Route::get('/{any}', function(){
//     return view('home');
// })->where('any','.*');
// Route::get('/{any?}', 'HomeController@index')->name('index')->where('any', '.*');
Route::get('{all}', 'HomeController@index')->where('all', '^((?!auth).)*');


Auth::routes();

Route::group(['prefix' => 'auth', 'middleware' => ['guest']], function () {
  // Route::get('login', 'Auth\SocialController@viewLogin');

  Route::get('login/{provider}', 'Auth\SocialController@redirectToProvider');
  Route::get('{provider}/callback', 'Auth\SocialController@handleProviderCallback');

  // Route::post('login', 'LoginController@login');
  // Route::post('logout', 'LoginController@logout');
  // Route::post('refresh', 'AuthController@refresh');
  // Route::post('me', 'AuthController@me');
  // Auth::routes();
});




// Route::group(['prefix' => 'profiles', 'as' => 'profiles.'],
//   function () {
//       Route::get('/', 'User\ProfileController@index')->name('index');
//       Route::get('/{profile}', 'User\ProfileController@show')->name('show');

//       Route::get('{profile}', 'User\ProfileController@create')->name('create')->middleware('auth');
//       Route::get('{profile}', 'User\ProfileController@update')->name('update')->middleware('auth');
// });