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

// Route::get('/', function(){
//     return view('welcome');
// });

Auth::routes();

// Route::get('/', 'HomeController@index');

Route::group(['middleware' => ['guest']], function () {
  Route::get('auth/login', 'Auth\SocialController@viewLogin');

  Route::get('auth/login/{provider}', 'Auth\SocialController@redirectToProvider');
  Route::get('auth/{provider}/callback', 'Auth\SocialController@handleProviderCallback');

  // Route::get('auth/login/twitter', 'Auth\SocialController@redirectToTwitterProvider');
  // Route::get('auth/twitter/callback', 'Auth\SocialController@handleTwitterProviderCallback');
});




// Route::group(['prefix' => 'profiles', 'as' => 'profiles.'],
//   function () {
//       Route::get('/', 'User\ProfileController@index')->name('index');
//       Route::get('/{profile}', 'User\ProfileController@show')->name('show');

//       Route::get('{profile}', 'User\ProfileController@create')->name('create')->middleware('auth');
//       Route::get('{profile}', 'User\ProfileController@update')->name('update')->middleware('auth');
// });