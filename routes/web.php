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
    return view('layout');
});

Route::get('/sessions', 'AssistenceController@get_sessions')->name('web.sessions');
Route::get('/calendar', 'AssistenceController@get_calendar')->name('web.calendar');
Route::get('/students', 'AssistenceController@get_students')->name('web.students');

Route::prefix('cmsapi')->name('cmsapi')->group(function () {
    Route::get('/calendar/get-sessions', 'AssistenceController@cmsapi_get_sessions')->name('cmsapi.calendar.get-sessions');
    Route::get('/students', 'AssistenceController@cmsapi_get_students')->name('cmsapi.students');
    Route::get('/students/get-classrooms', 'AssistenceController@cmsapi_get_classrooms')->name('cmsapi.students.get-classrooms');
    Route::get('/students/get-groups', 'AssistenceController@cmsapi_get_groups')->name('cmsapi.students.get-groups');
});
