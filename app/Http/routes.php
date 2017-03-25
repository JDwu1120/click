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
Route::any('addArticle',['uses' => 'ArticleController@addArticle']);
Route::any('featureArticle',['uses' => 'ArticleController@featureArticle']);
Route::any('latestArticle',['uses' => 'ArticleController@latestArticle']);
Route::any('showTag',['uses' => 'ArticleController@showTag']);
Route::any('showCategory',['uses' => 'ArticleController@showCategory']);
Route::any('article/articleImg',['uses' => 'ArticleController@articleImg']);
Route::any('showArticle',['uses' => 'ArticleController@showArticle']);
Route::any('showOneArticle',['uses' => 'ArticleController@showOneArticle']);
Route::any('delArticle',['uses' => 'ArticleController@delArticle']);
Route::any('editArticle',['uses' => 'ArticleController@editArticle']);
Route::any('queryArticle',['uses' => 'ArticleController@queryArticle']);
Route::any('viewArticle',['uses' => 'UserController@viewArticle']);
Route::any('colArticle',['uses' => 'UserController@colArticle']);
Route::any('collectionList',['uses' => 'UserController@collectionList']);
Route::any('isCollection',['uses' => 'UserController@isCollection']);
Route::any('delCollection',['uses' => 'UserController@delCollection']);
Route::any('comment',['uses' => 'UserController@comment']);
Route::any('delComment',['uses' => 'UserController@delComment']);
Route::any('checkLog',['uses' => 'UserController@checkLog']);