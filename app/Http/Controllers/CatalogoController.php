<?php

namespace CivicApp\Http\Controllers;

use CivicApp\DAL\Catalog\ICatalogRepository;
use CivicApp\Utilities\Logger;
use Illuminate\Http\Request;

use CivicApp\Http\Requests;

class CatalogoController extends Controller
{
    private $catalogRepository ;
    public  function __construct(ICatalogRepository $catalogRepo)
    {
        $this->catalogRepository = $catalogRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  string  $catalogo
     * @return \Illuminate\Http\Response
     */
    public function show($catalogo)
    {
        $method = 'show';
        try {
           $values = null;
            $result = 'OK';
            $message= null;
            Logger::startMethod($method);
            switch ($catalogo) {
                case 'Categorias':
                    $values =  $this->catalogRepository->GetAllCategories();
                    break;
                case 'Barrios' :
                    $values = $this->catalogRepository->GetAllBarrios();
                    break;
                case 'Cpcs':
                    $values = $this->catalogRepository->GetAllCpcs();
                    break;
                case 'Estados':
                    $values = $this->catalogRepository->GetAllStatuses();
                    break;
                case 'Años':
                    $years       = [ ];
                    $currentYear = date('Y') + 1;
                    for ($i = $currentYear; $i > ( $currentYear - 10 ); $i--) {
                        $years[] = $i;
                    }

                    $values =$years;
                    break;
                default:
                    $result ='ERROR';
                    $message = 'Parámetro Incorrecot para retornar un catálog específico';
                    break;
            }

            return response()->json(['status'=>$result,'data'=>$values,'message'=>$message]);

        }
        catch(\Exception $ex)
        {
            Logger::logError($method, $ex->getMessage());
            return response()->json(['status'=>'Error'
                                ,'message'=>'Error al Intentar obtener Catagolo.'.$ex->getMessage()
                                ,'ErrorCode'=>$ex->getCode()]);
        }
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
