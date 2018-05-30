<?php

namespace App\Http\Controllers;

use Config;
use App\Helpers\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class LanguageController extends Controller
{
  public function switch($lang)
  {
    if (array_key_exists($lang, Config::get('languages')))
        Session::put('applocale', $lang);

    return Redirect::back();
  }
}
