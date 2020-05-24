<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware'=>['web']], function () {
    Route::get('captcha/{config?}', 'AuthController@captcha');
    /*下面就是github认证所需的路由*/
    //Route::get('auth/github', 'GithubController@redirectToProvider');
    //Route::get('auth/github/callback', 'GithubController@handleProviderCallback');
    // 第三方登录
    Route::get('/oauth/github', 'Auth\LoginController@redirectToProvider');
    Route::get('/oauth/github/callback', 'Auth\LoginController@handleProviderCallback');
});

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/login', 'LoginController@index');
