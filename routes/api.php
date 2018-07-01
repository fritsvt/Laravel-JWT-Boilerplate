<?php

/* Guest but auth possible routes */
Route::group(['prefix' => '/v1', 'middleware' => ['throttle:100,5', 'jwt-guest', 'session']], function() {
    Route::get('', 'api\HomeController@index');
});

/* Auth routes */
Route::group(['prefix' => '/v1', 'middleware' => ['throttle:20,5', 'jwt-auth']], function () {
    Route::get('/me', 'api\Auth\UserInfoController@index')->name('api.register');
    Route::get('/logout', 'api\Auth\UserInfoController@logout')->name('api.register');
});

/* Guest routes */
Route::group(['prefix' => '/v1/auth', 'middleware' => ['throttle:20,5']], function () {
    Route::post('/login', 'api\Auth\LoginController@login')->name('api.login');
    Route::post('/register', 'api\Auth\RegisterController@register')->name('api.register');
});