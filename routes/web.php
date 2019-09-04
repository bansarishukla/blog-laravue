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

use App\Http\Controllers\PostController;

Route::get('/', 'PostController@getPosts');
Route::get('/get-post/{id}/post', 'PostController@readMore');
Route::get('/home','HomeController@index')->name('home');
Route::get('/posts/{id}/filter', 'PostController@filterByCategory');
Auth::routes();

Route::group(['middleware' => ['auth','admin']], function(){
    Route::get('/adminhome', function() {
        return view('admin.adminhome');
    });
    Route::get('/adminhome', 'PostController@index')->name('adminhome');
    Route::post('/adminhome', 'PostController@store')->name('adminstore');
    Route::put('adminhome/{id}', 'PostController@update');
    Route::get('/adminhome/{id}/edit', 'PostController@edit');
    Route::delete('adminhome/{id}', 'PostController@destroy');
    Route::resource('/category', 'CategoryController');

});


