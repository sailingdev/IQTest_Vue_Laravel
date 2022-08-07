<?php

use Illuminate\Http\Request;

// get request from materlu.com
// Route::post('orders', 'Api\V1\OrdersController@store');
Route::get('/test', function () {
    return "1";
});

Route::get('/', function () {
    //return redirect('/admin/home');
    return redirect('/user/home');
});
Route::get('admin/', function () {
    return redirect('/admin/home');
});



// Localization
Route::get('/js/lang.js', ['as' => 'locale', function (Request $request) {

    Cache::forget('lang.js');
    $strings = Cache::rememberForever('lang.js', function () {
        global $request;
        $lang = $request->session()->get('locale', 'en');

        $file   = resource_path('lang/' . $lang . '/userpage.php');

        $strings = [];


        if (!file_exists($file)) {
            $file   = resource_path('lang/en/userpage.php');
        }
        $name           = basename($file, '.php');
        $strings[$name] = require $file;

        return $strings;
    });

    header('Content-Type: text/javascript');
    echo ('window.i18n = ' . json_encode($strings) . ';');
    exit();
}])->name('assets.lang');

// Authentication Routes...

$this->get('login', 'Auth\LoginController@showLoginForm')->name('login');
$this->post('login', 'Auth\LoginController@login')->name('auth.login');
$this->post('admin/logout', 'Auth\LoginController@logout')->name('auth.logout');

// Change Password Routes...
$this->get('change_password', 'Auth\ChangePasswordController@showChangePasswordForm')->name('auth.change_password');
$this->patch('change_password', 'Auth\ChangePasswordController@changePassword')->name('auth.change_password');

// Password Reset Routes...
$this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('auth.password.reset');
$this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('auth.password.reset');
$this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
$this->post('password/reset', 'Auth\ResetPasswordController@reset')->name('auth.password.reset');


Route::group(['middleware' => ['auth'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('/{any}', 'HomeController@index')->where('any', '.*');
});


Route::group(['prefix' => 'user', 'as' => 'user.'], function () {
    Route::group(['prefix' => 'home', 'as' => 'home.'], function () {
        Route::get('/{any?}', 'CustomerController@index')->where('any', '(.*)');
    });
    Route::group(['prefix' => 'main', 'as' => 'main.'], function () {
        Route::get('/{any?}', 'CustomerController@testView')->where('any', '(.*)');
    });
});
