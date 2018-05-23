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
      $user = App\User::findOrFail(1);
      dump('test', $user->test($user));
      dump('isFriendWith(1)', $user->isFriendWith(1));
      dump('hasFriendshipRequestFrom(1)', $user->hasFriendshipRequestFrom(1));
      dump('hasSentFriendshipRequestTo(2)', $user->hasSentFriendshipRequestTo(2));
      dump('getFriendship(2)', $user->getFriendship(2));
      dump('getAllFriendships()', $user->getAllFriendships());
      dump('getPendingFriendships()', $user->getPendingFriendships());
      dump('getAcceptedFriendships()', $user->getAcceptedFriendships());
      dump('getFriends()', $user->getFriends());
      dump('getFriendsCount()', $user->getFriendsCount());
      dump('getPendingFriendshipsCount()', $user->getPendingFriendshipsCount());
    });
});
