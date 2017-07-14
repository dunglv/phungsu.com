<?php
//  Handle from UI
Route::group(['middleware' => 'auth'], function() {
    Route::get('/create-new',[
        'as' => 'ui.create',
        'uses' => 'HandleController@article_create_home'
        ]);
    Route::get('/article/create-article', [
        'as' => 'ui.article.create-article',
        'uses' => 'HandleController@article_create_normal'
        ]);
    Route::post('/article/create-article', [
        'as' => 'ui.article.create-article-store',
        'uses' => 'HandleController@article_create_normal_store'
        ]);

    Route::get('/article/upload-mp3', [
        'as' => 'ui.article.upload-mp3',
        'uses' => 'HandleController@article_create_mp3'
        ]);
    Route::post('/article/upload-mp3', [
        'as' => 'ui.article.upload-mp3-store',
        'uses' => 'HandleController@article_create_mp3_store'
        ]);
    
    Route::get('/article/upload-video', [
        'as' => 'ui.article.upload-video',
        'uses' => 'HandleController@article_create_video'
        ]);
    Route::post('/article/upload-video', [
        'as' => 'ui.article.upload-video-store',
        'uses' => 'HandleController@article_create_video_store'
        ]);

    Route::get('/article/upload-image', [
        'as' => 'ui.article.upload-image',
        'uses' => 'HandleController@article_create_image'
        ]);
    Route::post('/article/upload-image', [
        'as' => 'ui.article.upload-image-store',
        'uses' => 'HandleController@article_create_image_store'
        ]);

    Route::get('/article/handle-req', [
        'as' => 'ui.article.handle-req',
        'uses' => 'HandleController@handle_req_article'
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



// Handle Admin
Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function() {
    Route::get('/article', ['as' => 'ad.a.index', 'uses' => 'AdminController@article_home']);

    Route::get('/article/create', ['as' => 'ad.a.create', 'uses' => 'AdminController@article_create']);

    Route::get('/article/create-normal', ['as' => 'ad.a.create-normal', 'uses' => 'AdminController@article_create_normal']);

    Route::post('/article/create-normal', ['as' => 'ad.a.create-normal-store', 'uses' => 'AdminController@article_create_normal_store']);
    // Drirect admin to edit page article mp3
    Route::get('/article/{id}/edit', ['as' => 'ad.a.edit-normal', 'uses' => 'AdminController@article_edit_normal']);
    // Update article after edit mp3
    Route::post('/article/{id}/edit', ['as' => 'ad.a.edit-normal-update', 'uses' => 'AdminController@article_edit_normal_update']);
    // Drirect admin to edit page article mp3
    Route::get('/article/create-mp3', ['as' => 'ad.a.create-mp3', 'uses' => 'AdminController@article_create_mp3']);
    // Update article after edit mp3
    Route::post('/article/create-mp3', ['as' => 'ad.a.create-mp3-store', 'uses' => 'AdminController@article_create_mp3_store']);
	// Approving article to display front  
    Route::get('/article/pending', ['as' => 'ad.a.pending', 'uses' => 'AdminController@article_pending']);
	// Locked article and hide it on front
    Route::get('/article/locked', ['as' => 'ad.a.locked', 'uses' => 'AdminController@article_locked']);
    // Delete article from user 
    Route::get('/article/{id}/delete', ['as' => 'ad.a.delete', 'uses' => 'AdminController@article_delete']);
    //
    Route::get('/article/{id}/active', ['as' => 'ad.a.active', 'uses' => 'AdminController@article_active']);
});