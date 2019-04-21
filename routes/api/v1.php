<?php


Route::group(['prefix' => 'api', 'as' => 'api.', 'namespace' => 'Api'], function() {
    Route::group(['prefix' => 'v1', 'as' => 'v1.', 'namespace' => 'V1'], function() {

      Route::group(['prefix' => 'auth'], function ($router) {

          Route::post('login', 'AuthController@login');
          Route::post('logout', 'AuthController@logout');
          Route::post('refresh', 'AuthController@refresh');
          Route::post('me', 'AuthController@me');

      });

      // Route::group(['middleware' => 'api.auth'], function() {
      Route::group([], function() {
        Route::group(['prefix' => 'profiles', 'as' => 'profiles.'],
          function () {
              Route::get('/', 'ProfileController@index')->name('index');
              Route::get('/{profile}', 'ProfileController@show')->name('show');
              // Route::get('{profile}', 'ProfileController@create')->name('create')->middleware('auth');
              Route::put('/{profile}', 'ProfileController@update')->name('update');

              Route::post('/search', 'ProfileController@search');
              Route::post('/{profile}/contact', 'ProfileController@contact');

              Route::post('/{profile}/like', 'MatchController@like');
        });
        Route::group(['prefix' => 'matches', 'as' => 'matches.'],
          function () {
              Route::post('/users', 'MatchController@matchedUsers');
        });
      });


    });
});


/* %%ROUTES%% */
Route::get('auth/login/facebook', 'Auth\SocialController@redirectToFacebookProvider');
Route::get('auth/facebook/callback', 'Auth\SocialController@handleFacebookProviderCallback');