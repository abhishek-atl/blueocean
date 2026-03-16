<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home(Request $request)
    {
        $request->session()->forget('booking');
        return view('frontend.modules.home.index');
    }
}
