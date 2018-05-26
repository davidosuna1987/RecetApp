<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

use App\User;
use App\Friendship;

class FriendshipsTest extends TestCase
{
    /** @test */
    public function user_can_send_a_friend_request()
    {
        Friendship::truncate();
        $sender = User::findOrFail(1);
        $recipient = User::findOrFail(2);

        $sender->sendFriendshipRequest($recipient);

        $this->assertCount(1, $recipient->getPendingFriendships());
    }

    /** @test */
    public function user_can_not_send_a_friend_request_if_frienship_is_pending()
    {
        Friendship::truncate();
        $sender = User::findOrFail(1);
        $recipient = User::findOrFail(2);

        $sender->sendFriendshipRequest($recipient);
        $sender->sendFriendshipRequest($recipient);
        $sender->sendFriendshipRequest($recipient);

        $this->assertCount(1, $recipient->getPendingFriendships());
    }

    /** @test */
    public function user_can_send_a_friend_request_if_frienship_is_denied()
    {
        Friendship::truncate();
        $sender = User::findOrFail(1);
        $recipient = User::findOrFail(2);

        $sender->sendFriendshipRequest($recipient);
        $recipient->denyFriendshipRequest($sender);

        $sender->sendFriendshipRequest($recipient);

        $this->assertCount(1, $recipient->getPendingFriendships());
    }

    /** @test */
    public function user_can_remove_a_friend_request()
    {
        Friendship::truncate();
        $sender = User::findOrFail(1);
        $recipient = User::findOrFail(2);

        $sender->sendFriendshipRequest($recipient);
        $this->assertCount(1, $recipient->getPendingFriendships());
        $sender->deleteFriendship($recipient);
        $this->assertCount(0, $recipient->getPendingFriendships());

        // Can resend friend request after deleted
        $sender->sendFriendshipRequest($recipient);
        $this->assertCount(1, $recipient->getPendingFriendships());
        $recipient->acceptFriendshipRequest($sender);
        $this->assertEquals(true, $recipient->isFriendWith($sender));

        // Can remove friend request after accepted
        $sender->deleteFriendship($recipient);
        $this->assertEquals(false, $recipient->isFriendWith($sender));
    }

    /** @test */
    public function user_is_friend_with_another_user_if_accepts_a_friend_request()
    {
        Friendship::truncate();
        $sender = User::findOrFail(1);
        $recipient = User::findOrFail(2);

        $sender->sendFriendshipRequest($recipient);
        $recipient->acceptFriendshipRequest($sender);

        $this->assertTrue($recipient->isFriendWith($sender));
        $this->assertTrue($sender->isFriendWith($recipient));
        $this->assertCount(0, $recipient->getPendingFriendships());
    }

    /** @test */
    public function user_is_not_friend_with_another_user_until_he_accepts_a_friend_request()
    {
        Friendship::truncate();
        $sender = User::findOrFail(1);
        $recipient = User::findOrFail(2);

        $sender->sendFriendshipRequest($recipient);

        $this->assertFalse($recipient->isFriendWith($sender));
        $this->assertFalse($sender->isFriendWith($recipient));
    }

    /** @test */
    public function user_has_friend_request_from_another_user_if_he_received_a_friend_request()
    {
        Friendship::truncate();
        $sender = User::findOrFail(1);
        $recipient = User::findOrFail(2);

        $sender->sendFriendshipRequest($recipient);

        $this->assertTrue($recipient->hasFriendshipRequestFrom($sender));
        $this->assertFalse($sender->hasFriendshipRequestFrom($recipient));
    }

    /** @test */
    public function user_has_sent_friend_request_to_this_user_if_he_already_sent_request()
    {
        Friendship::truncate();
        $sender = User::findOrFail(1);
        $recipient = User::findOrFail(2);

        $sender->sendFriendshipRequest($recipient);

        $this->assertFalse($recipient->hasSentFriendshipRequestTo($sender));
        $this->assertTrue($sender->hasSentFriendshipRequestTo($recipient));
    }

    /** @test */
    public function user_has_not_friend_request_from_another_user_if_he_accepted_the_friend_request()
    {
        Friendship::truncate();
        $sender = User::findOrFail(1);
        $recipient = User::findOrFail(2);

        $sender->sendFriendshipRequest($recipient);
        $recipient->acceptFriendshipRequest($sender);

        $this->assertFalse($recipient->hasFriendshipRequestFrom($sender));
        $this->assertFalse($sender->hasFriendshipRequestFrom($recipient));
    }

    /** @test */
    public function user_cannot_accept_his_own_friend_request()
    {
        Friendship::truncate();
        $sender = User::findOrFail(1);
        $recipient = User::findOrFail(2);

        $sender->sendFriendshipRequest($recipient);

        $sender->acceptFriendshipRequest($recipient);
        $this->assertFalse($recipient->isFriendWith($sender));
    }

    /** @test */
    public function user_can_deny_a_friend_request()
    {
        Friendship::truncate();
        $sender = User::findOrFail(1);
        $recipient = User::findOrFail(2);

        $sender->sendFriendshipRequest($recipient);
        $recipient->denyFriendshipRequest($sender);

        $this->assertFalse($recipient->isFriendWith($sender));
        $this->assertCount(0, $recipient->getPendingFriendships());
    }

    /** @test */
    public function it_returns_all_user_friendships()
    {
        Friendship::truncate();
        $sender = User::findOrFail(1);
        $recipients = [];
        $recipients[] = User::findOrFail(2);
        $recipients[] = User::findOrFail(3);
        $recipients[] = User::findOrFail(4);

        foreach ($recipients as $recipient) {
            $sender->sendFriendshipRequest($recipient);
        }

        $recipients[0]->acceptFriendshipRequest($sender);
        $recipients[1]->acceptFriendshipRequest($sender);
        $recipients[2]->denyFriendshipRequest($sender);
        $this->assertCount(2, $sender->getAllFriendships());
    }
}
