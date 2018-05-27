<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    protected $fillable = [
      'category_id', 'name', 'preparation'
    ];

    public function category()
    {
      $this->belongsTo(Category::class);
    }

    public function tags()
    {
      $this->hasMany(Tag::class);
    }
}
