<?php

// -----------------------------------------------------------------------------
// Join
// -----------------------------------------------------------------------------
Route::get('join', 'RegistrationController@show')->name('join');
Route::post('join', 'RegistrationController@store');

Route::get('join/next', 'ConfirmRegistrationController@show')
    ->name('join.next');

// -----------------------------------------------------------------------------
// Login
// -----------------------------------------------------------------------------
Route::get('/login', 'LoginController@show')->name('login');
Route::post('/login', 'LoginController@store');
Route::get('/login/next', 'SessionController@show')->name('login.next');

Route::get('/login/token/{token}','SessionController@store')
    ->name('login.validate-token');

Route::get('/login/nope', 'InvalidTokenController@show')
    ->name('login.invalid-token');

// -----------------------------------------------------------------------------
// Manage account
// -----------------------------------------------------------------------------
Route::get('/account', 'AccountController@show')->name('account');
Route::post('/account', 'AccountController@store');
