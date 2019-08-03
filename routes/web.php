<?php

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

use App\User;
use App\Video;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');

Route::get('/crear-video','VideoController@createVideo')->name('createVideo')->middleware('auth');
Route::post('/guardar-video','VideoController@saveVideo')->name('saveVideo')->middleware('auth');
Route::get('/miniatura/{filename}','VideoController@Image')->name('imageVideo')->middleware('auth');
Route::get('/detallevideo/{idvideo}','VideoController@videoDetaill')->name('videoDetaill')->middleware('auth');
Route::get('/show-video/{filename}','VideoController@ShowVideo')->name('showvideo')->middleware('auth');
Route::post('/comment','CommentController@addCommentVideo')->name('comment')->middleware('auth');
Route::get('/eliminar-comentario/{videoid}/{commentid}','CommentController@deleteCommentVideo')->name('deleteComment')->middleware('auth');
Route::get('/eliminar-video/{videoid}','VideoController@deleteVideo')->name('deleteVideo')->middleware('auth');
Route::get('/editar-video/{idvideo}','VideoController@videoEditForm')->name('videoEditForm')->middleware('auth');
Route::post('/guardaredicion-video/{id}','VideoController@saveEditionVideo')->name('saveEditionVideo')->middleware('auth');
Route::get('/busqueda-video','VideoController@searchVideo')->name('searchVideo')->middleware('auth');
Route::get('/canal/{id}','UserController@channel')->name('channel')->middleware('auth');