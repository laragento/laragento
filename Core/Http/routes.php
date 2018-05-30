<?php

Route::group(['middleware' => 'web', 'prefix' => '', 'namespace' => 'Laragento\Core\Http\Controllers\Auth'],
    function () {

        // Authentication Routes...
        Route::get('login', 'LoginController@showLoginForm')->name('login');
        Route::post('login', 'LoginController@login');
        Route::post('logout', 'LoginController@logout')->name('logout');

        // Registration Routes...
        Route::get('register', 'RegisterController@showRegistrationForm')->name('register');
        Route::post('register', 'RegisterController@register');

        // Password Reset Routes...
        Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
        Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
        Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
        Route::post('password/reset', 'ResetPasswordController@reset');
    });

Route::group(['middleware' => 'web', 'prefix' => 'core', 'namespace' => 'Laragento\Core\Http\Controllers'], function()
{
    Route::get('/', 'CoreController@index');
});


