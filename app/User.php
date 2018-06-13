<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Hootlex\Friendships\Traits\Friendable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, Friendable;

    protected $fillable = [
        'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $appends = [
        'full_name', 'avatar'
    ];

    public function getFullNameAttribute()
    {
        return $this->email;
    }

    public function getAvatarAttribute()
    {
        return 'http://www.gravatar.com/avatar/'.md5($this->email).'fs=150';
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function recipes()
    {
        return $this->hasMany(Recipe::class);
    }
}
