<?php

namespace App\Http\Controllers\Frontend;

use Config;

use App\Http\Controllers\Controller;


class HomeController extends Controller
{
    /**
     * Show the application homepage.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('frontend.homepage');
    }

}
