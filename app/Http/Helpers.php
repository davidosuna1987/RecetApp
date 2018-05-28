<?php

use App\Helpers\Language;

class Helpers
{
  public static function getLanguages()
  {
    return Language::all();
  }
}
