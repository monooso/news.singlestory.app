<?php

// -----------------------------------------------------------------------------
// Testing mailables...
// -----------------------------------------------------------------------------
Route::get('/mailable', function () {
    $password = factory(\App\Models\Token::class)->create();

    return new \App\Mail\UserRegistrationToken($password->user);
});

// -----------------------------------------------------------------------------
// Join
// -----------------------------------------------------------------------------
Route::get('join', 'RegistrationController@show')->name('join');
Route::post('join', 'RegistrationController@store');

Route::get(
    'join/next',
    'ConfirmRegistrationController@show'
)->name('join.next');

// -----------------------------------------------------------------------------
// Login
// -----------------------------------------------------------------------------
Route::get('/login', 'LoginController@show')->name('login');
Route::post('/login', 'LoginController@store');

Route::get('/login/next', 'SessionController@show')->name('login.next');

Route::get(
    '/login/token/{token}',
    'SessionController@store'
)->name('login.validate-token');

Route::get(
    '/login/nope',
    'InvalidTokenController@show'
)->name('login.invalid-token');

// -----------------------------------------------------------------------------
// Manage account
// -----------------------------------------------------------------------------
Route::get('/account', 'AccountController@show')->name('account');
Route::post('/account', 'AccountController@store');

/*
Route::get('/', 'RegistrationController@show')->name('home');

Route::post(
    '/register',
    'UnconfirmedUserController@store'
)->name('register');

Route::get(
    '/register/check',
    'UnconfirmedUserController@show'
)->name('check-email');

Route::get(
    '/register/duplicate',
    'DuplicateUserController@show'
)->name('duplicate-email');

Route::get(
    '/register/confirm/{password}',
    'ConfirmedUserController@store'
)->name('confirm-registration');
*/
