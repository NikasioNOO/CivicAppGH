<?php

namespace CivicApp\Http\Controllers;

use Illuminate\Http\Request;

use CivicApp\Http\Requests;

class ObrasSocialController extends Controller
{
    public  function getIndex()
    {
        return view('ObrasPresupuestoSocial');
    }

}
