<?php

namespace CivicApp\Http\Controllers;

use CivicApp\BLL\Catalog\CatalogHandler;
use CivicApp\Utilities\Logger;
use Illuminate\Http\Request;

use CivicApp\Http\Requests;
use Illuminate\Support\Collection;

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

    public function AddBarrio(Request $request )
    {

        if(!$request->has('newValue'))
        {
            response()->json(['status'=>'Error',
                              'message'=>'Error al recibir el barrio para agregar']);
        }

        $barrio = $request->newValue;

        $newBarrio = $this->catalogHandler->AddBarrio($barrio);

        return response()->json(['status' =>'Ok',
                                 'data'=>  $newBarrio]);

    }

    public function AddCpc(Request $request )
    {

        if(!$request->has('newValue'))
        {
            response()->json(['status'=>'Error',
                              'message'=>'Error al recibir el cpc para agregar']);
        }

        $cpc = $request->newValue;

        $newCpc = $this->catalogHandler->AddCpc($cpc);

        return response()->json(['status' =>'Ok',
                                 'data'=>  $newCpc]);

    }

    public  function  postUploadIcons(Request $request)
    {
        $method = 'postUploadIcons';
        Logger::startMethod($method);
        try {

            if($request->has('filesNames'))
            {

                $filesNames = explode(',',$request->filesNames);
                $saveFiles = new Collection();
                foreach( $filesNames as $file){
                    if($request->hasFile($file)) {
                        $iconFile = $request->file($file);
                        $iconFilename = 'cat' . $request->categoryId . '_' . $file . '.' . $iconFile->getClientOriginalExtension();
                        $iconFile->move(env('MAPICONS_PATH'),$iconFilename);
                        $saveFiles->push($iconFilename);

                    }
                }

                if(count($saveFiles) > 0)
                {
                    $this->catalogHandler->SaveCategoriesImages($request->categoryId, $saveFiles);
                }

            }


            Logger::endMethod($method);

            return response()->json([
                'status' => 'Ok',
                'data'   => ''
            ]);
        }
        catch(\Exception $ex)
        {
            response()->json([
                'status'  => 'Error',
                'message' => $ex->getMessage(),
                'ErrorCode' => $ex->getCode()
            ]);
        }
    }

    public  function  postSaveBarrioLocation(Request $request)
    {
        $method = 'postSaveBarrioLocation';
        Logger::startMethod($method);
        try {

            if($request->has('barrioId') && $request->has('location'))
            {
                $this->catalogHandler->SaveBarrioLocation($request->barrioId, $request->location);
            }
            else
            {
                throw new \Exception('No se recibieron  los parámetros correctamente');
            }


            Logger::endMethod($method);

            return response()->json([
                'status' => 'Ok',
                'data'   => ''
            ]);
        }
        catch(\Exception $ex)
        {
            response()->json([
                'status'  => 'Error',
                'message' => $ex->getMessage(),
                'ErrorCode' => $ex->getCode()
            ]);
        }
    }


}
