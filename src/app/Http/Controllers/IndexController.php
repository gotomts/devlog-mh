<?php

namespace App\Http\Controllers;

use App\Http\Controllers\WebBaseController;
use Illuminate\Http\Request;

class IndexController extends WebBaseController
{
    public function showIndex()
    {
        return view('welcome');
    }
}
