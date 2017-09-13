<?php

namespace CivicApp\Http\Controllers;

use CivicApp\BLL\Obra\ObraHandler;
use CivicApp\BLL\Post\PostHandler;
use CivicApp\Utilities\Logger;
use Illuminate\Http\Request;

use CivicApp\Http\Requests;

class ObraPPController extends Controller
{

    private $obraHandler;
    private $postHandler;


    public function __construct(ObraHandler $obraHandlerParam, PostHandler $postHandlerParam)
    {
        $this->obraHandler = $obraHandlerParam;
        $this->postHandler = $postHandlerParam;

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $method = 'index';
        $message = null;

        try {

            Logger::startMethod($method);

            $obras = $this->obraHandler->GetAllObras();


            Logger::endMethod($method);

            return response()->json([
                'status' => 'OK',
                'data'   => $obras,
                'message' => $message
            ]);
        }
        catch(\Exception $ex)
        {
            return  response()->json([
                'status'  => 'ERROR',
                'message' => 'Se ha producido un error al obtener todas las obras del presupuesto particiipativo.'.$ex->getMessage(),
                'ErrorCode' => $ex->getCode()
            ]);
        }
    }

    public function Search($year, $categoryId, $barrioId )
    {

        $criteria = [];

        if($year != -1)
            $criteria["year"] = $year;
        if($categoryId != -1)
            $criteria["category"]= $categoryId;
        if($barrioId != -1)
            $criteria["barrio"]= $barrioId;

        $obras = $this->obraHandler->SearchByCriteria($criteria);


        return response()->json([
            'status' => 'OK',
            'data'   => $obras,
            'message' => ''
        ]);

    }

    public function GetPosts($id, $orderBy='created_at', $orderType='desc')
    {
        $message = null;
        $method='GetPosts';
        try {

            Logger::startMethod($method);

            $obras = $this->postHandler->GetAllPostByObra($id);


            Logger::endMethod($method);

            return response()->json([
                'status' => 'OK',
                'data'   => $obras,
                'message' => $message
            ]);
        }
        catch(\Exception $ex)
        {
            return  response()->json([
                'status'  => 'ERROR',
                'message' => 'Se ha producido un error al obtener todas las obras del presupuesto particiipativo.'.$ex->getMessage(),
                'ErrorCode' => $ex->getCode()
            ]);
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
