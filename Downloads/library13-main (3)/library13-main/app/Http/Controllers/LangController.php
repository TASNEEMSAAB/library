<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;

class LangController extends Controller
{
    function setLang(Request $request){
        $lang = $request->lang;
        // return $lang;
        $cookie = Cookie::make("language" , $lang , 525600 );    
        return back()->withCookie($cookie);
    }
}
