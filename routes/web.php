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



Auth::routes();

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function(){

  // Test routes
  Route::get('/test/user', function(){
    dump(Auth::user()->load('profile'));
  });

  Route::get('/test/recipes', function(){
    dump(Auth::user()->recipes()->with('categories', 'tags', 'ingredients')->get());
  });
});
