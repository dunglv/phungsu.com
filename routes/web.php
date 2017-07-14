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
// foreach(File::allFiles(__DIR__, '/routes') as $partial)
// {
// dd (get_class_methods($partial));
// }

Route::get('/',	[
	'as' => 'ui.home',
	'uses' => 'HandleController@home'
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
});

foreach (File::allFiles(__DIR__.'/own-route') as $file) {
	if (file_exists($file->getPathName())) {
		require $file->getPathName();
	}
}

Auth::routes();
Route::get('/user/finish-register', ['uses' => 'AdminController@finish_register', 'as' => 'ui.user.finish-register']);

Route::get('/confirm-email-active', ['uses'=>'AdminController@activation_email_do', 'as' => 'ui.user.confirm_email']);

Route::get('/success-active', ['uses' => 'AdminController@activation_email_success', 'as' => 'ui.user.success-active']);

