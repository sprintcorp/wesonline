<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'

], function () {
    Route::post('/login', 'Auth\AuthController@login')->name('login');
    Route::post('/register', 'Auth\AuthController@register');
    Route::post('/logout', 'Auth\AuthController@logout');
    Route::post('/refresh', 'Auth\AuthController@refresh');
    Route::get('/user-profile', 'Auth\AuthController@userProfile');    
    Route::put('/user-password', 'Auth\AuthController@passwordReset');    
    Route::put('/reset/{token}', 'Auth\AuthController@resetToken')->name('reset_link');  
    
    //System Admin Route
    Route::resource('super-admin-employer','Super\EmployerController');
    Route::resource('super-admin-training','Super\TrainingController');
    Route::resource('super-admin-section','Super\SectionController');
});
