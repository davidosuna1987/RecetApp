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

  // Recipes routes
  Route::get('/recipes', 'RecipeController@index')->name('recipes');
  Route::get('/recipes/create', 'RecipeController@create')->name('recipes.create');
  Route::post('/recipes', 'RecipeController@store')->name('recipes.store');
  Route::get('/recipes/{id}', 'RecipeController@show')->name('recipes.show');

  // Categories routes
  Route::get('/categories', 'CategoryController@index')->name('categories');
  // Route::get('/categories/create', 'CategoryController@create')->name('categories.create');
  // Route::post('/categories', 'CategoryController@store')->name('categories.store');

  // Test routes
  Route::get('/test/user', function(){
    dump(Auth::user()->load('profile'));
  });

  Route::get('/test/recipes', function(){
    dump(Auth::user()->recipes()->with('categories', 'tags', 'ingredients')->get());
  });
});
