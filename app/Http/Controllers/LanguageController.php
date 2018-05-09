<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class LanguageController extends Controller
{
    public function setLanguage($lang)
    {
        if(in_array($lang, ['en', 'hy'])){
            Session::put('locale', $lang);
            Cookie::queue('locale', $lang, 24 * 60);
        }
        $uri = URL::previous();
        $newUri = str_replace(['&lang=en', '&lang=hy'], '&lang='.$lang,  $uri);
        return redirect()->to($newUri);
    }

}
