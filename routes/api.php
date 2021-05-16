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
    Route::resource('super-admin-student','Super\StudentController');
    Route::resource('super-admin-training','Super\TrainingController');
    Route::resource('super-admin-section','Super\SectionController');
    Route::resource('super-admin-module','Super\ModuleController');
    Route::resource('super-admin-school','Super\SchoolController');

    //    School Admin Route
    Route::resource('school-admin-cordinator','Admin\SiwesCordinatorController');
    Route::resource('school-admin-supervisor','Admin\SiwesSupervisorController');
    Route::resource('school-admin-student','Admin\StudentController');
    Route::resource('school-supervisor-student','Admin\StudentSupervisorController');

    //    Employer/Company Route
    Route::resource('company-employee','Company\EmployeeController');
    Route::resource('company-internship','Company\InternshipController');
    Route::resource('company-webinar','Company\WebinarController');
    Route::resource('company-announcement','Company\AnnouncementController');
    //Role management
    Route::get('/permissions', 'Role\RoleManager@permissionsIndex')
        ->name('permissions.index')
        ->middleware('permission:View All Permissions');

    Route::get('/roles', 'Role\RoleManager@rolesIndex');

    Route::post('/roles/{role}/assign/{user}', 'Role\RoleManager@rolesAddUser')
        ->name('roles.addUser')
        ->middleware('permission:Assign Role');

    Route::post('/permission/{permission}/assign/{user}', 'Role\RoleManager@permissionAddUser')
        ->name('permission.addUser')->middleware('permission:Assign Role');

    Route::post('/roles/{role}/unassign/{user}', 'Role\RoleManager@rolesRemoveUser')
        ->name('roles.removeUser')
        ->middleware('permission:Unassign Role');
});
