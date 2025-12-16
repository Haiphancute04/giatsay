<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StaticPageController extends Controller
{
    public function showPolicy()
    {
        return view('static.chinh-sach');
    }
    public function showTerms()
    {
        return view('static.dieu-khoan'); 
    }

    public function showSupport()
    {
        return view('static.ho-tro'); 
    }
}
