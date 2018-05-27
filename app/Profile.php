<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
      'user_id', 'first_name', 'last_name', 'avatar',
      'address', 'city', 'country', 'zip_code'
    ];

    public function user()
    {
      return $this->belongsTo(User::class);
    }
}
