<?php

namespace App\Traits;

use App\User;
use App\Friendship;
use Illuminate\Support\Facades\Auth;

trait Friendable
{
  public function sendFriendshipRequest($id)
  {
    $friendship = Auth::user()->getFriendship($id);

    if(!$friendship):
      $friendship = Friendship::create([
        'sender_id' => Auth::user()->id,
        'recipient_id' => $id,
        'accepted' => false
      ]);
    endif;

    return $friendship;
  }

  public function acceptFriendshipRequest($id)
  {
    $friendship = Friendship::where([
      'sender_id' => $id,
      'recipient_id' => Auth::user()->id
    ])->first();

    if($friendship):
      $friendship->update([
        'accepted' => true
      ]);
    endif;

    return $friendship;
  }

  public function denyFriendshipRequest($id)
  {
    return $this->deleteFriendship($id);
  }

  public function deleteFriendship($id)
  {
    $friendship = Friendship::where([
      'sender_id' => $id,
      'recipient_id' => Auth::user()->id
    ])->first();

    if($friendship)
      $friendship->delete();

    return true;
  }

  public function isFriendWith($id)
  {
    $friendship = Friendship::where([
      'sender_id' => Auth::user()->id,
      'recipient_id' => $id,
      'accepted' => true
    ])->first();

    if(!$friendship):
      $friendship = Friendship::where([
        'sender_id' => $id,
        'recipient_id' => Auth::user()->id,
        'accepted' => true
      ])->first();
    endif;

    return $friendship ? true : false;
  }

  public function hasFriendshipRequestFrom($id)
  {
    $friendship = Friendship::where([
      'sender_id' => $id,
      'recipient_id' => Auth::user()->id,
      'accepted' => false
    ])->first();

    return $friendship ? true : false;
  }

  public function hasSentFriendshipRequestTo($id)
  {
    $friendship = Friendship::where([
      'sender_id' => Auth::user()->id,
      'recipient_id' => $id,
      'accepted' => false
    ])->first();

    return $friendship ? true : false;
  }

  public function getFriendship($id)
  {
    $friendship = Friendship::where([
      'sender_id' => Auth::user()->id,
      'recipient_id' => $id
    ])->orWhere([
      'sender_id' => $id,
      'recipient_id' => Auth::user()->id
    ])->first();

    return  $friendship;
  }

  public function getAllFriendships()
  {
    $friendships = Friendship::where('sender_id', Auth::user()->id)
        ->orWhere('recipient_id', Auth::user()->id)
        ->get();

    return $friendships;
  }

  public function getPendingFriendships()
  {
    $friendships = Friendship::where([
      'recipient_id' => Auth::user()->id,
      'accepted' => false
    ])->get();

    return $friendships;
  }

  public function getAcceptedFriendships()
  {
    $friendships = Friendship::where([
      'recipient_id' => Auth::user()->id,
      'accepted' => true
    ])->get();

    return $friendships;
  }

  public function getPendingFriendshipsCount()
  {
    $friendships = Auth::user()->getPendingFriendships();

    return count($friendships);
  }

  public function getFriends()
  {
    $friendships = Friendship::where([
      'sender_id' => Auth::user()->id,
      'accepted' => true
    ])->orWhere([
      'recipient_id' => Auth::user()->id,
      'accepted' => true
    ])->get();

    $friends = collect();

    foreach($friendships as $key => $friendship):
      if($friendship->sender_id != Auth::user()->id)
        $friends->push(User::findOrFail($friendship->sender_id));
      else
        $friends->push(User::findOrFail($friendship->recipient_id));
    endforeach;

    return $friends;
  }

  public function getFriendsCount()
  {
    $friendships = Auth::user()->getFriends();

    return count($friendships);
  }
}
