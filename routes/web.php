<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
| +tag, +article, +user, +category
*/
Route::get('/',	[
	'as' => 'ui.home',
	'uses' => 'HandleController@home'
	]);

Route::get('/home', 'HomeController@index');

/******************************************/
/* +search
/******************************************/
Route::get('search', [
	'as' => 'ui.search.result',
	'uses' => 'HandleController@search_result'
	]);


/******************************************/
/* +comment
/******************************************/
Route::post('/article/{slug}/comment-save', [
	'as' => 'ui.comment.store',
	'uses' => 'HandleController@comment_store'
	]);

Route::get('/comment/handle-req-comment', [
	'as' => 'ui.comment.handle-req-comment',
	'uses' => 'HandleController@handle_req_comment'
	]);

/******************************************/
/* +contribute
/******************************************/
Route::get('/your-ideas-to-contribute', [
	'as' => 'ui.you.contribute',
	'uses' => 'HandleController@you_contribute'
	]);


Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function() {
    Route::get('/', ['as' => 'ad.home', 'uses' => 'AdminController@home']);
});

if (file_exists(__DIR__.'/own-route/route-article.php')) {
	require __DIR__.'/own-route/route-article.php';
}

if (file_exists(__DIR__.'/own-route/route-category.php')) {
	require __DIR__.'/own-route/route-category.php';
}

if (file_exists(__DIR__.'/own-route/route-tag.php')) {
	require __DIR__.'/own-route/route-tag.php';
}

if (file_exists(__DIR__.'/own-route/route-user.php')) {
	require __DIR__.'/own-route/route-user.php';
}

Auth::routes();

