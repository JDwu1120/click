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
Route::group(['middleware'=>'ajaxPermission'],function (){
    Route::any('showArticle',['uses' => 'ArticleController@showArticle']);
    Route::any('showOneArticle',['uses' => 'ArticleController@showOneArticle']);
    Route::any('queryArticle',['uses' => 'ArticleController@queryArticle']);
    Route::any('viewArticle',['uses' => 'ArticleController@viewArticle']);
    Route::any('homepage',['uses' => 'ArticleController@homepage']);
    Route::any('getUserInfo',['uses' => 'LoginController@getUserInfo']);
    Route::any('getLogin',['uses' => 'LoginController@getLogin']);
    Route::any('getToken',['uses' => 'LoginController@getToken']);
    Route::any('showOneTag',['uses' => 'ArticleController@showOneTag']);
    Route::any('showOneCategory',['uses' => 'ArticleController@showOneCategory']);
    Route::group(['middleware'=>'checkLogin'],function (){
        Route::any('addArticle',['uses' => 'UserController@addArticle']);
        Route::any('article/articleImg',['uses' => 'UserController@articleImg']);
        Route::any('delArticle',['uses' => 'UserController@delArticle']);
        Route::any('editArticle',['uses' => 'UserController@editArticle']);
        Route::any('colArticle',['uses' => 'UserController@colArticle']);
        Route::any('collectionList',['uses' => 'UserController@collectionList']);
        Route::any('isCollection',['uses' => 'UserController@isCollection']);
        Route::any('delCollection',['uses' => 'UserController@delCollection']);
        Route::any('comment',['uses' => 'UserController@comment']);
        Route::any('delComment',['uses' => 'UserController@delComment']);
        Route::any('getInfo',['uses' => 'UserController@getInfo']);
        Route::any('agreeComs',['uses' => 'UserController@agreeComs']);
        Route::any('reply',['uses' => 'UserController@reply']);
        Route::any('showUserMsg',['uses' => 'UserController@showUserMsg']);
    });
    Route::any('verifySend','MailController@verifySend');
    Route::any('userRegister','RegisterController@userRegister');
    Route::any('userLogin','LoginController@localLogin');
    Route::any('userLogout','LoginController@localLogout');
});
Route::any('test',['uses' => 'TestController@test']);