<?php

// -----------------------------------------------------------------------------
// Home
// -----------------------------------------------------------------------------
Route::get('/', 'HomeController@show')->name('home');

// -----------------------------------------------------------------------------
// Join
// -----------------------------------------------------------------------------
Route::redirect('join', '/', 301);

Route::post('join', 'RegistrationController@store')->name('join');

Route::get('join/next', 'ConfirmRegistrationController@show')
    ->name('join.next');

// -----------------------------------------------------------------------------
// Login
// -----------------------------------------------------------------------------
Route::get('login', 'LoginController@show')->name('login');
Route::post('login', 'LoginController@store');
Route::get('login/next', 'SessionController@show')->name('login.next');

Route::get('login/token/{token}','SessionController@store')
    ->name('login.validate-token');

// -----------------------------------------------------------------------------
// Logout
// -----------------------------------------------------------------------------
Route::get('logout', 'SessionController@destroy')->name('logout');

// -----------------------------------------------------------------------------
// Manage account
// -----------------------------------------------------------------------------
Route::get('account', 'AccountController@show')->name('account');
Route::post('account', 'AccountController@store');

Route::get('account/delete', 'AccountController@delete')
    ->name('account.delete');

Route::delete('account', 'AccountController@destroy')->name('account.destroy');
