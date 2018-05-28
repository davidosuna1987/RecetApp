<?php

namespace App\Helpers;

use App;
use Config;

class Language
{
  public static function all()
  {
    $languages = [];

    foreach(Config::get('languages') as $language => $names):
        if($language === App::getLocale()):
            $languages = $names;
        endif;
    endforeach;

    return $languages;
  }
}
