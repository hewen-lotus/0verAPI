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

Route::resource('/', 'MainRouteController', ['only' => [
    'index'
]]);

Route::get('/users/login', 'Auth\LoginController@UserLoginStatus');

Route::post('/users/login', 'Auth\LoginController@UserLogin');

Route::post('/users/logout', 'Auth\LoginController@UserLogout');

Route::resource('/schools.editors', 'SchoolEditorController', ['only' => [
    'index', 'store', 'show', 'update'
]]);

Route::resource('/schools.histories', 'SchoolHistoryDataController', ['only' => [
    'store', 'show'
]]);

Route::resource('/schools.systems.histories', 'SystemHistoryDataController', ['only' => [
    'store', 'show'
]]);

Route::resource('/schools.systems.departments.histories', 'DepartmentHistoryDataController', ['only' => [
    'store', 'show'
]]);

Route::resource('/systems.application-document-types', 'ApplicationDocumentTypeController', ['only' => [
    'index', 'store', 'show', 'update', 'destroy'
]]);

Route::resource('/department-groups', 'DepartmentGroupController', ['only' => [
    'index'
]]);

Route::resource('/evaluation-levels', 'EvaluationLevelController', ['only' => [
    'index'
]]);

// 系統輸出簡章調查回覆表
Route::post('/schools/{school_code}/systems/{system_id}/guidelines-reply-form', 'GuidelinesReplyFormGeneratorController@gen');

// 突然跑出來的第一階段，又沒了
//Route::resource('/schools.quotas', 'SystemQuotaController');

// 名額查詢
Route::resource('/quota-inquire', 'QuotaInquireController', ['only' => [
    'index'
]]);

Route::get('/limesurvey-filemtime', 'LimesurveyFilemtimeController@export');