<?php

//use Illuminate\Support\Facades\Request;
use Illuminate\Http\Request;

use App\Category;
use App\Services\Image;

use Illuminate\Support\Facades\Auth;

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

Route::get('/', 'imagesController@index');

Route::get('/create', 'imagesController@create')->middleware('user');

Route::post('/store', 'imagesController@store');

Route::get('/show/{id}', 'imagesController@show');

Route::get('/edit/{id}', 'imagesController@edit');

Route::post('/update/{id}', 'imagesController@update');

Route::get('/delete/{id}', 'imagesController@delete');

Route::get('/category/{id}', 'imagesController@categoryShow');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');



///////////////////////////////////////
Route::group(['as' => 'admin.', 'namespace'=>'Admin', 'prefix' => 'admin', 'middleware' => ['admin']], function() {
	Route::get('/', 'HomeController@index');
        Route::get('/posts', 'PostsController@index')->name('posts');
        Route::delete('/posts/{d}', 'PostsController@destroy');
        
        Route::get('/posts/create', 'PostsController@create')->name('posts.create');
        Route::get('/posts/edit/{d}', 'PostsController@edit')->name('posts.edit');
        Route::post('/posts/store', 'PostsController@store');
        Route::put('/posts/update/{d}', 'PostsController@update')->name('posts.update');
        
        Route::get('users/', 'UsersController@index')->name('users');
        Route::get('users/create', 'UsersController@create')->name('users.create');
        Route::post('users/store', 'UsersController@store');
        Route::get('users/edit/{d}', 'UsersController@edit')->name('users.edit');
        Route::put('users/update/{d}', 'UsersController@update')->name('users.update');
        Route::delete('users/destroy/{d}', 'UsersController@destroy')->name('users.destroy');
        
        Route::get('categories/', 'CategoriesController@index')->name('categories');
        Route::get('categories/create', 'CategoriesController@create')->name('categories.create');
        Route::post('categories/store', 'CategoriesController@store')->name('categories.store');
        Route::get('categories/edit/{d}', 'CategoriesController@edit')->name('categories.edit');
        Route::put('categories/update/{d}', 'CategoriesController@update')->name('categories.update');
        Route::delete('categories/destroy/{d}', 'CategoriesController@destroy')->name('categories.destroy');
});


