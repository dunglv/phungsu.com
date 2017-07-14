<?php
Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function() {
	// Route::get('/setting', [
	// 	'as' => 'ad.set.home',
	// 	'uses' => 'AdminController@setting_home'
	// 	]);

	// Route::post('/setting', [
	// 	'as' => 'ad.set.home_update',
	// 	'uses' => 'AdminController@setting_home_update'
	// 	]);
});