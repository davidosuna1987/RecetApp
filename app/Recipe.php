<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    protected $fillable = [
      'user_id', 'image', 'title', 'preparation'
    ];

    public function user()
    {
      return $this->belongsTo(User::class);
    }

    public function categories()
    {
      return $this->belongsToMany(Category::class);
    }

    public function tags()
    {
      return $this->belongsToMany(Tag::class);
    }

    public function ingredients()
    {
      return $this->belongsToMany(Ingredient::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }
}
