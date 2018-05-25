<?php

namespace App\Traits;

use App\User;
use App\Friendship;
use Illuminate\Support\Facades\Auth;

trait Friendable
{
  public function test($user)
  {
    $id = $user instanceof User ? $user->id : $user;
    return $id;
  }

  public function sendFriendshipRequest($user)
  {
    $id = $user instanceof User ? $user->id : $user;

    $friendship = $this->getFriendship($id);

    if(!$friendship):
      $friendship = Friendship::create([
        'sender_id' => $this->id,
        'recipient_id' => $id,
        'accepted' => false
      ]);
    endif;

    return $friendship;
  }

  public function acceptFriendshipRequest($user)
  {
    $id = $user instanceof User ? $user->id : $user;

    $friendship = Friendship::where([
      'sender_id' => $id,
      'recipient_id' => $this->id
    ])->first();

    if($friendship):
      $friendship->update([
        'accepted' => true
      ]);
    endif;

    return $friendship;
  }

  public function denyFriendshipRequest($user)
  {
    $id = $user instanceof User ? $user->id : $user;

    return $this->deleteFriendship($id);
  }

  public function deleteFriendship($user)
  {
    $id = $user instanceof User ? $user->id : $user;

    $friendship = Friendship::where([
      'sender_id' => $id,
      'recipient_id' => $this->id
    ])->orWhere([
      'sender_id' => $this->id,
      'recipient_id' => $id
    ])->first();

    if($friendship)
      $friendship->delete();

    return true;
  }

  public function isFriendWith($user)
  {
    $id = $user instanceof User ? $user->id : $user;

    $friendship = Friendship::where([
      'sender_id' => $this->id,
      'recipient_id' => $id
    ])->orWhere([
      'sender_id' => $id,
      'recipient_id' => $this->id
    ])->first();

    return $friendship and $friendship->accepted ? true : false;
  }

  public function hasFriendshipRequestFrom($user)
  {
    $id = $user instanceof User ? $user->id : $user;

    $friendship = Friendship::where([
      'sender_id' => $id,
      'recipient_id' => $this->id,
      'accepted' => false
    ])->first();

    return $friendship ? true : false;
  }

  public function hasSentFriendshipRequestTo($user)
  {
    $id = $user instanceof User ? $user->id : $user;

    $friendship = Friendship::where([
      'sender_id' => $this->id,
      'recipient_id' => $id,
      'accepted' => false
    ])->first();

    return $friendship ? true : false;
  }

  public function getFriendship($user)
  {
    $id = $user instanceof User ? $user->id : $user;

    $friendship = Friendship::where([
      'sender_id' => $this->id,
      'recipient_id' => $id
    ])->orWhere([
      'sender_id' => $id,
      'recipient_id' => $this->id
    ])->first();

    return  $friendship;
  }

  public function getAllFriendships()
  {
    $friendships = Friendship::where('sender_id', $this->id)
        ->orWhere('recipient_id', $this->id)
        ->get();

    return $friendships;
  }

  public function getPendingFriendships()
  {
    $friendships = Friendship::where([
      'recipient_id' => $this->id,
      'accepted' => false
    ])->get();

    return $friendships;
  }

  public function getAcceptedFriendships()
  {
    $friendships = Friendship::where([
      'recipient_id' => $this->id,
      'accepted' => true
    ])->get();

    return $friendships;
  }

  public function getPendingFriendshipsCount()
  {
    $friendships = $this->getPendingFriendships();

    return count($friendships);
  }

  public function getAcceptedFriendshipsCount()
  {
    $friendships = $this->getAcceptedFriendships();

    return count($friendships);
  }

  public function getFriends()
  {
    $friendships = Friendship::where([
      'sender_id' => $this->id,
      'accepted' => true
    ])->orWhere([
      'recipient_id' => $this->id,
      'accepted' => true
    ])->get();

    $friends = collect();

    foreach($friendships as $key => $friendship):
      if($friendship->sender_id != $this->id)
        $friends->push(User::findOrFail($friendship->sender_id));
      else
        $friends->push(User::findOrFail($friendship->recipient_id));
    endforeach;

    return $friends;
  }

  public function getFriendsCount()
  {
    $friendships = $this->getFriends();

    return count($friendships);
  }
}
