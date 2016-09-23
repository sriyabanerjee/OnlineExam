<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('list/{id}','ListController@listDetails');
Route::get('check','ListController@testBlade');
Route::any('bootgrid','ListController@testBootGrid');
Route::get('testing','ListController@test');//for bootgrid application
Route::get('checkDatabase','ListController@testDatabase');//for filemaker connection

Route::get('login',function(){
    $msg="";
    return view('users.login')->with('msg',$msg);
});


Route::any('loginController','Users\UserController@isUser');//for handling login task
Route::any('editUserProfile','Users\UserController@editUserDetails');//for handling login task