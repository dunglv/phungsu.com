<?php
Route::group(['middleware' => 'auth'], function() {
    Route::get('/logout', [
    	'as' => 'ui.logout',
    	'uses' => 'HandleController@logout'
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

// Handle route from ADMIn
Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function() {
	// +user
	Route::get('/user', ['as' => 'ad.u.index', 'uses' => 'AdminController@user_home']);

	Route::get('/user/pending', ['as' => 'ad.u.pending', 'uses' => 'AdminController@user_pending']);

	Route::get('/user/deactive', ['as' => 'ad.u.deactive', 'uses' => 'AdminController@user_deactive']);

	Route::get('user/{id}/lock', [
		'as' => 'ad.u.lock',
		'uses' => 'AdminController@user_lock'
		]);

	Route::get('user/{id}/auth', [
		'as' => 'ad.u.auth',
		'uses' => 'AdminController@user_auth'
		]);

	Route::post('user/{id}/auth', [
		'as' => 'ad.u.auth_update',
		'uses' => 'AdminController@user_auth_update'
		]);

	Route::get('user/{id}/delete', [
		'as' => 'ad.u.delete',
		'uses' => 'AdminController@user_delete'
		]);
});
