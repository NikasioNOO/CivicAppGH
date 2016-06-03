<?php

namespace CivicApp\Http\Controllers;

use CivicApp\BLL\Catalog\CatalogHandler;
use Illuminate\Http\Request;

use CivicApp\Http\Requests;

class CatalogController extends Controller
{
    protected $catalogHandler ;
    public function __construct(CatalogHandler $handler)
    {
        $this->catalogHandler = $handler;
    }

    public function AddCategory(Request $request )
    {

        if(!$request->has('newValue'))
        {
            response()->json(['status'=>'Error',
                'message'=>'Error al recibir la categoria para agregar']);
        }


        $category = $request->newValue;

        $newCategory = $this->catalogHandler->AddCategory($category);

        return response()->json(['status' =>'Ok',
            'data'=>  $newCategory]);

    }
}
