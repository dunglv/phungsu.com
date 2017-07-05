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
Route::group(['middleware' => 'auth'], function() {
    Route::get('/logout', [
    	'as' => 'ui.logout',
    	'uses' => 'HandleController@logout'
    	]);
    Route::get('/create-new',[
		'as' => 'ui.create',
		'uses' => 'HandleController@home_create'
		]);

	Route::get('/article/upload-mp3', [
		'as' => 'ui.article.upload-mp3',
		'uses' => 'HandleController@article_upload_mp3'
		]);
	Route::post('/article/upload-mp3', [
		'as' => 'ui.article.upload-mp3-store',
		'uses' => 'HandleController@article_upload_mp3_store'
		]);
	Route::get('/article/upload-video', [
		'as' => 'ui.article.upload-video',
		'uses' => 'HandleController@article_create'
		]);
	Route::get('/article/upload-image', [
		'as' => 'ui.article.upload-image',
		'uses' => 'HandleController@article_create'
		]);
	Route::get('/article/create-article', [
		'as' => 'ui.article.create-article',
		'uses' => 'HandleController@article_create'
		]);
	Route::post('/article/create-article', [
		'as' => 'ui.article.create-article-store',
		'uses' => 'HandleController@article_create_store'
		]);
	Route::get('/article/handle-req', [
		'as' => 'ui.article.handle-req',
		'uses' => 'HandleController@handle_req_article'
		]);

	Route::get('/change-password', [
		'as' => 'ui.user.change-password',
		'uses' => 'HandleController@user_change_password'
		]);
	Route::post('/change-password', [
		'as' => 'ui.user.change-password-update',
		'uses' => 'HandleController@user_change_password_update'
		]);
});
Auth::routes();

/**
 * Detail of article
 * Format is normal, audio, video, image with separate view display
 *
 **/
Route::get('/article/audio-{slug}.html',[
	'as' => 'ui.article.detail-mp3',
	'uses' => 'HandleController@article_detail_mp3'
	]);
Route::get('/article/{slug}.html',[
	'as' => 'ui.article.detail',
	'uses' => 'HandleController@article_detail'
	]);

/******************************************/
/* +tag
/******************************************/
Route::get('tag/{slug}', [
	'as' => 'ui.tag.detail',
	'uses' => 'HandleController@tag_detail'
	]);


Route::get('/home', 'HomeController@index');



/******************************************/
/* +category
/******************************************/
Route::get('category/{slug}', [
	'as' => 'ui.category.detail',
	'uses' => 'HandleController@category_detail'
	]);


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