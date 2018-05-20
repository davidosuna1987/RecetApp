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



Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function(){
    Route::get('/users/friendships/send/{id}', 'UserController@sendFriendshipRequest');
    Route::get('/users/friendships/accept/{id}', 'UserController@acceptFriendshipRequest');
    Route::get('/users/friendships/deny/{id}', 'UserController@denyFriendshipRequest');

    Route::get('/test', function(){
      $user = \Auth::user();
      dump($user->isFriendWith(1));
      dump($user->hasFriendshipRequestFrom(1));
      dump($user->hasSentFriendshipRequestTo(2));
      dump($user->getFriendship(2));
      dump($user->getAllFriendships());
      dump($user->getPendingFriendships());
      dump($user->getAcceptedFriendships());
      dump($user->getFriends());
      dump($user->getFriendsCount());
      dump($user->getPendingFriendshipsCount());
    });
});
