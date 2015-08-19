<?php

namespace CivicApp\Http\Controllers;

use Illuminate\Http\Request;

use CivicApp\Http\Requests;
use CivicApp\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        return \View::make('home');

    }
}
