<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Friendship extends Model
{
    protected $fillable = [
      'sender_id', 'recipient_id', 'accepted'
    ];
}