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

Route::post('/login', 'AuthController@login');

Route::get('contacts', 'ContactsController@index');
Route::post('contacts','ContactsController@store');
Route::get('groups', 'GroupsController@index');
Route::post('groups','GroupsController@store');
Route::post('contactInfo','ContactsController@contactInfo');
Route::post('groupInfo','GroupsController@contactInfo');
Route::get('fetchGroups','ContactsController@fetchGroups');
Route::put('users/{user}', 'ContactsController@assignGroup');
Route::post('sendSms','ContactsController@sendSms');


Route::group([        
    'middleware' => 'api',    
    'prefix' => 'password'
], function () {    
    Route::post('create', 'PasswordResetController@create');
    Route::get('find/{token}', 'PasswordResetController@find');
    Route::post('reset', 'PasswordResetController@reset');
});