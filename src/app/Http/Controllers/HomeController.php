<?php

namespace App\Http\Controllers;

use App\Http\Controllers\WebBaseController;
use Illuminate\Http\Request;

class HomeController extends WebBaseController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showHome()
    {
        return view('home');
    }
}
