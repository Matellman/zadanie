<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'comments'], function () {  
    Route::get('{hotel_id}', [
        'uses' => 'CommentsController@show',
        'as'   => 'show_comments',
    ]);   
    Route::post('{hotel_id}', [
        'uses' => 'CommentsController@store',
        'as'   => 'store_comments',
    ]);
    Route::patch('edit/{comment_id}', [
        'uses' => 'CommentsController@edit',
        'as'   => 'edit_comments',
    ]);
    Route::delete('remove/{comment_id}', [
        'uses' => 'CommentsController@remove',
        'as'   => 'delete_comments',
    ]);
});

Route::group(['prefix' => 'subcomments'], function () { 
    Route::post('{comment_id}', [
        'uses' => 'SubCommentsController@store',
        'as'   => 'store_subcomments',
    ]);
});

    
