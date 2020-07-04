<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('', 'HomeController@index')->name('home');

Route::prefix('file-upload-local')->name('file_upload_local.')->group(function () {
    Route::get('test', 'FileUploadController@localTest')->name('test');
    Route::get('basic', 'FileUploadController@localBasic')->name('basic');
    Route::get('get', 'FileUploadController@getLocalFile')->name('get');
    Route::get('download', 'FileUploadController@downloadLocalFile')->name('download');
    Route::get('tmp-url-1-min', 'FileUploadController@setTempUrl1Minute')->name('tmp_url');
    Route::get('upload', 'FileUploadController@uploadLocalFile')->name('upload');
    Route::post('upload-post', 'FileUploadController@uploadLocalFilePost')->name('upload_post');
});

Route::prefix('file-upload-s3')->name('file_upload_s3.')->group(function () {
    Route::get('upload-single-file', function (){
        require_once '../app/Customize/s3_upload_single_file.php';
    })->name('upload_single_file');
    Route::post('upload-single-file', function (){
        require_once '../app/Customize/s3_upload_single_file.php';
    })->name('upload_single_file_post');
    Route::get('get-files', function (){
        require_once '../app/Customize/s3_get_files.php';
    })->name('get_files');
});

