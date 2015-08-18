<?php

namespace AppCivicas\Http\Controllers;

use Illuminate\Http\Request;

use AppCivicas\Http\Requests;
use AppCivicas\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        return \View::make('home');

    }
}
