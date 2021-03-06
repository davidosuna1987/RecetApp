<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        // return view('users');
    }

    public function authuser()
    {
        return response()->json([
            'authuser' => Auth::user()->load(['profile', 'recipes', 'likes'])
        ]);
    }

    public function sendFriendshipRequest($id)
    {
        $response = Auth::user()->sendFriendshipRequest($id);

        return response()->json([
            'friendships' => $response
        ]);
    }

    public function acceptFriendshipRequest($id)
    {
        $response = Auth::user()->acceptFriendshipRequest($id);

        return response()->json([
            'friendships' => $response
        ]);
    }

    public function denyFriendshipRequest($id)
    {
        $response = Auth::user()->denyFriendshipRequest($id);

        return response()->json([
            'denyed' => $response
        ]);
    }
}
