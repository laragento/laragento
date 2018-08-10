<?php

Route::group(['middleware' => 'web', 'prefix' => 'admin', 'namespace' => 'Laragento\Admin\Http\Controllers'],
    function () {
        // Override AuthRoutes from Laragento
        Route::get('/login', 'Auth\LoginController@showForm')->name('admin.login.show');
        Route::post('/login', 'Auth\LoginController@login')->name('admin.login');
        Route::post('/logout', 'Auth\LoginController@logout')->name('admin.logout');

        // Registration Routes...
        Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('admin.register.show');
        Route::post('register', 'Auth\RegisterController@register')->name('admin.register');

        // Password Reset Routes...
        Route::get('password/request',
            'Auth\ForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
        Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
        Route::get('password/reset/{token}',
            'Auth\ResetPasswordController@showResetForm')->name('admin.password.reset.show');
        Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('admin.password.reset');
        Route::group(['middleware' => 'auth:admins'], function () {

            // Admin only routes
            Route::get('/', 'AdminController@index')->name('admin.index');
        });
    });
