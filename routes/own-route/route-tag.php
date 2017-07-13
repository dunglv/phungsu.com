<?php
Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function() {
	// +tag
    Route::get('/tag', ['as' => 'ad.tag.index', 'uses' => 'AdminController@tag_home']);

    Route::get('/tag/create', ['as' => 'ad.tag.create', 'uses' => 'AdminController@tag_create']);

    Route::post('/tag/create', ['as' => 'ad.tag.store', 'uses' => 'AdminController@tag_store']);

    Route::get('/tag/pending', ['as' => 'ad.tag.pending', 'uses' => 'AdminController@tag_pending']);

    Route::get('/tag/locked', ['as' => 'ad.tag.locked', 'uses' => 'AdminController@tag_locked']);

    Route::get('/tag/{id}/active', [
    	'as' => 'ad.tag.active',
    	'uses' => 'AdminController@tag_active'
    	]);

    Route::get('/tag/{id}/edit', [
    	'as' => 'ad.tag.edit',
    	'uses' => 'AdminController@tag_edit'
    	]);

    Route::post('/tag/{id}/edit', [
    	'as' => 'ad.tag.update',
    	'uses' => 'AdminController@tag_update'
    	]);
});

/******************************************/
/* +tag
/******************************************/
Route::get('tag/{slug}', [
	'as' => 'ui.tag.detail',
	'uses' => 'HandleController@tag_detail'
	]);