<?php
Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function() {

	// +category
	Route::get('/category', ['as' => 'ad.cate.index', 'uses' => 'AdminController@category_home']);

	Route::get('/category/create', ['as' => 'ad.cate.create', 'uses' => 'AdminController@category_create']);

	Route::post('/category/create', ['as' => 'ad.cate.create_store', 'uses' => 'AdminController@category_store']);

	Route::get('/category/{id}/edit', ['as' => 'ad.cate.edit', 'uses' => 'AdminController@category_edit']);

	Route::post('/category/{id}/edit', ['as' => 'ad.cate.create_update', 'uses' => 'AdminController@category_update']);

	Route::get('/category/{id}/active', ['as' => 'ad.cate.active', 'uses' => 'AdminController@category_active']);

	Route::get('/category/pending', ['as' => 'ad.cate.pending', 'uses' => 'AdminController@category_pending']);

	Route::get('/category/locked', ['as' => 'ad.cate.locked', 'uses' => 'AdminController@category_locked']);
});



/******************************************/
/* +category
/* UI
/******************************************/
Route::get('category/{slug}', [
	'as' => 'ui.category.detail',
	'uses' => 'HandleController@category_detail'
	]);
