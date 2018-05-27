<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    protected $fillable = [
      'user_id', 'name', 'preparation'
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
      return $this->hasMany(Ingredient::class);
    }
}
