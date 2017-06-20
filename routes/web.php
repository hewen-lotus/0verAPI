<?php

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

Route::get('/users/login', 'Auth\LoginController@UserLoginStatus');

Route::post('/users/login', 'Auth\LoginController@UserLogin');

Route::post('/users/logout', 'Auth\LoginController@UserLogout');

Route::resource('/schools.editors', 'SchoolEditorController');

Route::resource('/schools.histories', 'SchoolHistoryDataController');

Route::resource('/schools.systems.histories', 'SystemHistoryDataController');

Route::resource('/schools.systems.departments.histories', 'DepartmentHistoryDataController');

Route::resource('/systems.application-document-types', 'ApplicationDocumentTypeController');

Route::get('/pdf', 'PDFGeneratorController@gen');

// 突然跑出來的第一階段，又沒了
//Route::resource('/schools.quotas', 'SystemQuotaController');

Route::get('/limesurvey-filemtime', 'LimesurveyFilemtimeController@export');