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
Route::any('password/{activationCode}',function($activationCode){
    
    return view('users.password')->with('activationCode',$activationCode);
});
Route::any('confirmation','Users\UserController@setPassword');//for setting password
Route::any('passwordL/{activationCode}',function($activationCode){
    
    return view('users.passwordLink')->with('activationCode',$activationCode);
});
Route::any('searchAllQuestions','Questions\QuestionsController@searchQuestions');//for search all questions
Route::any('addQuestionBankRelate','Questions\QuestionsBankController@addQuestionBankRelate');//for adding questionBankRelate
Route::any('addQuestionsBank','Questions\QuestionsBankController@addQuestionsBank');//for add a questionBank
Route::any('editQuestion','Questions\QuestionsController@doEditQuestion');//for editing a question
Route::any('deleteQuestion','Questions\QuestionsController@deleteQuestionByRecordId');//for deleting a question according to recordID
Route::any('showsQuestion','Questions\QuestionsController@showQuestionByRecordId');//for showing question according to recordID
Route::any('showQuestion','Questions\QuestionsController@showQuestions');//for showing questions list
Route::any('addQuestion','Questions\QuestionsController@addQuestion');//for adding new question
Route::any('findAllcategories','Questions\QuestionsController@findAllCategoryNames');//for find all category names
Route::any('addcategories','Questions\QuestionsController@addCategory');//for add category
Route::any('deletecategories','Questions\QuestionsController@deleteCategoryByRecordId');//for delete category
Route::any('edit.categories','Questions\QuestionsController@doEditcategories');//for edit catagories
Route::any('categories','Questions\QuestionsController@showCategoris');//for showing categories
Route::any('setPassword/{activationCode}','Users\UserController@sendMail');//for sending mail to user
Route::any('adduser','Users\UserController@addNewUser');//for adding new user
Route::any('deleteuserByRecordID','Users\UserController@deleteUserByRecordId');//for deleting a user by record ID
Route::any('usersByRecordID','Users\UserController@showUserByRecordId');//for getting user's details by Record ID
Route::any('loginController','Users\UserController@isUser');//for handling login task
Route::any('editUserProfile','Users\UserController@editUserDetails');//for handling login task
Route::any('editUserProfileModal','Users\UserController@doEditUserDetails');//for handling login task
//Route::any('logout','Auth\AuthController@getLogout');//for handling logout task
Route::any('logout','Users\UserController@doLogOut');//for handling logout task
Route::any('showUsersList','Users\UserController@showUsers');//for showing users list