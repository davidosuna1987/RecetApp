<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

use App\User;

class FriendshipsTest extends TestCase
{
    /** @test */
    public function user_can_send_a_friend_request()
    {
        $sender    = User::findOrFail(1);
        $recipient = User::findOrFail(2);

        $sender->sendFriendshipRequest($recipient);

        $this->assertCount(1, $recipient->getPendingFriendships());
    }
}
