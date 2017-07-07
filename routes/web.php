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
	
	Route::get('/profile', [
		'as' => 'ui.user.detail',
		'uses' => 'HandleController@user_detail'
		]);
	Route::post('/profile', [
		'as' => 'ui.user.update-detail',
		'uses' => 'HandleController@user_update_profile'
		]);
	Route::get('/deactivate', [
		'as' => 'ui.user.deactivate',
		'uses' => 'HandleController@user_deactivate'
		]);
	Route::get('/setting', [
		'as' => 'ui.user.setting',
		'uses' => 'HandleController@user_setting'
		]);
	Route::get('/manage', [
		'as' => 'ui.user.manage',
		'uses' => 'HandleController@user_manage'
		]);
});

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

/******************************************/
/* +contribute
/******************************************/
Route::get('/your-ideas-to-contribute', [
	'as' => 'ui.you.contribute',
	'uses' => 'HandleController@you_contribute'
	]);


Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function() {
    Route::get('/', ['as' => 'ad.home', 'uses' => 'AdminController@home']);

    Route::get('/article', ['as' => 'ad.a.index', 'uses' => 'AdminController@article_home']);

    Route::get('/article/create', ['as' => 'ad.a.create', 'uses' => 'AdminController@article_create']);

    Route::get('/article/create-normal', ['as' => 'ad.a.create-normal', 'uses' => 'AdminController@article_create_normal']);

    Route::post('/article/create-normal', ['as' => 'ad.a.create-normal-store', 'uses' => 'AdminController@article_create_normal_store']);

    Route::get('/article/create-mp3', ['as' => 'ad.a.create-mp3', 'uses' => 'AdminController@article_create_mp3']);

    Route::post('/article/create-mp3', ['as' => 'ad.a.create-mp3-store', 'uses' => 'AdminController@article_create_mp3_store']);

    Route::get('/article/pending', ['as' => 'ad.a.pending', 'uses' => 'AdminController@article_pending']);

    Route::get('/article/locked', ['as' => 'ad.a.locked', 'uses' => 'AdminController@article_locked']);

    // +category
    Route::get('/category', ['as' => 'ad.cate.index', 'uses' => 'AdminController@category_home']);

    Route::get('/category/create', ['as' => 'ad.cate.create', 'uses' => 'AdminController@category_create']);

    Route::post('/category/create', ['as' => 'ad.cate.create_store', 'uses' => 'AdminController@category_store']);

    Route::get('/category/{id}/edit', ['as' => 'ad.cate.edit', 'uses' => 'AdminController@category_edit']);

    Route::post('/category/{id}/edit', ['as' => 'ad.cate.create_update', 'uses' => 'AdminController@category_update']);

    Route::get('/category/{id}/active', ['as' => 'ad.cate.active', 'uses' => 'AdminController@category_active']);

    Route::get('/category/pending', ['as' => 'ad.cate.pending', 'uses' => 'AdminController@category_pending']);

    Route::get('/category/locked', ['as' => 'ad.cate.locked', 'uses' => 'AdminController@category_locked']);

    // +tag
    Route::get('/tag', ['as' => 'ad.tag.index', 'uses' => 'AdminController@tag_home']);

    Route::get('/tag/create', ['as' => 'ad.tag.create', 'uses' => 'AdminController@tag_create']);

    Route::get('/tag/pending', ['as' => 'ad.tag.pending', 'uses' => 'AdminController@tag_pending']);

    Route::get('/tag/locked', ['as' => 'ad.tag.locked', 'uses' => 'AdminController@tag_locked']);

    // +user
    Route::get('/user', ['as' => 'ad.u.index', 'uses' => 'AdminController@user_home']);

    Route::get('/user/pending', ['as' => 'ad.u.pending', 'uses' => 'AdminController@user_pending']);

    Route::get('/user/deactive', ['as' => 'ad.u.deactive', 'uses' => 'AdminController@user_deactive']);

    Route::get('/user/locked', ['as' => 'ad.u.locked', 'uses' => 'AdminController@user_locked']);

});

Auth::routes();
