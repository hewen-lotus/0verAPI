<?php

use Illuminate\Http\Request;

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

/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
 */

//Route::auth();

Route::get('/users/login', 'Auth\LoginController@UserLoginStatus');

Route::post('/users/login', 'Auth\LoginController@UserLogin');

Route::post('/users/logout', 'Auth\LoginController@UserLogout');

Route::resource('/schools.editors', 'SchoolEditorController');

Route::resource('/schools.histories', 'SchoolHistoryController');

Route::resource('/schools.systems.histories', 'SystemHistoryController');

Route::resource('/schools.systems.departments.histories', 'DepartmentHistoryController');

Route::post('/personal-and-priority-data-importer', 'PersonalAndPriorityDataImportController@import');

Route::get('/db-schema-to-md', 'DBSchemaToMDController@export');

Route::get('/limesurvey-filemtime', 'LimesurveyFilemtimeController@export');

Route::post('/csv-to-seeder', 'CSVToSeederController@import');
