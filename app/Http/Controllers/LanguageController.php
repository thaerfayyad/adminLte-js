<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;



class LanguageController extends Controller
{
    //
    public function switchLang($lang)
    {
        if (array_key_exists($lang, Config::get('app.languages'))) {
            Session::put('locale', $lang);
        }
        return back();
    }
}
