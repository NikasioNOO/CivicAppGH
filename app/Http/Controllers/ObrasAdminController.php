<?php

namespace CivicApp\Http\Controllers;


use CivicApp\BLL\Auth\AuthHandler;
use CivicApp\BLL\Catalog\CatalogHandler;
use CivicApp\BLL\Obra\ObraHandler;
use CivicApp\BLL\Post\PostHandler;
use CivicApp\Entities\MapItem\Barrio;
use CivicApp\Entities\MapItem\Category;
use CivicApp\Entities\MapItem\Cpc;
use CivicApp\Entities\Common\GeoPoint;
use CivicApp\Models\Status;
use CivicApp\Utilities\IMapper;
use CivicApp\Utilities\Logger;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use CivicApp\Entities\MapItem\MapItem;
use CivicApp\Http\Requests;
use Gmaps;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class ObrasAdminController extends Controller
{

    private $obraHandler;
    private $catalogHandler;
    private $postHandler;

    public function __construct(ObraHandler $handler, CatalogHandler $catHandler, PostHandler $postHandlerParam)
    {
        $this->obraHandler = $handler;
        $this->catalogHandler = $catHandler;
        $this->postHandler = $postHandlerParam;
    }

    //
    public  function getIndex()
    {
        /*$config = array();
        $config['center'] = 'auto';
        //$config['cluster'] = TRUE;
        $config['zoom'] = 'auto';
        $config['places'] = TRUE;
        $config['placesAutocompleteInputID'] = 'autocompleteMap';
        $config['placesAutocompleteBoundsMap'] = TRUE; // set results biased towards the maps viewport
        $config['placesAutocompleteOnChange'] = 'CivicApp.GmapHelper.AutocompleteChange();';
        $config['onclick'] = 'createMarker_map({ map: map, position:event.latLng });';
        $config['apiKey'] = env('GMAP_APIKEY');
        $config['onboundschanged'] = 'if (!centreGot) {
            var mapCentre = map.getCenter();
            marker_0.setOptions({
                position: new google.maps.LatLng(mapCentre.lat(), mapCentre.lng())
            });
        }
        centreGot = true;';

        /*$marker = array();
        $marker['position'] = '-31.4029389, -64.18895850000001 ';
        $marker['infowindow_content'] = 'Casa';
        $marker['animation'] = 'DROP';
        $marker['icon'] = 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=A|9999FF|000000';*/

        // Gmaps::add_marker($marker);
/*
        $dircasa = Gmaps::get_lat_long_from_address('Mariano Fragueiro 1011, Córdoba, Argentina');

        Gmaps::initialize($config);

        // set up the marker ready for positioning
        // once we know the users location
        $marker = array();
        Gmaps::add_marker($marker);

        $map = Gmaps::create_map();*/

        return view('admin.obraspresupuesto');


    }

    private static $rulesSaveObra = [
        'year'              => 'required',
        'cpc'            => 'required|exists:cpc,id',
        'barrio'             => 'required|exists:barrios,id',
        'category'                 => 'required',
        'description'              => 'required',
        'budget' => 'required|numeric',
        'status' => 'required|exists:statuses,id'
    ];

    private static $messagesSaveObra = [
        'year.required'     => 'El año es requerido',
        'cpc.required'   => 'El CPC es requerido',
        'cpc.exists'    => 'El CPC debe existir',
        'barrio.required'        => 'El barrio es requerido',
        'barrio.exists'           => 'El barrio debe existir',
        'category.required'          => 'La categoría es requerida',
        'category.exists'     => 'La categoría debe existir',
        'description.required'          => 'El título de la obra es requerido',
        'budget.required'          => 'El presupuesto es requerido',
        'budget.numeric' => 'El presupuesto debe ser un valor numérico',
        'status.required'        => 'El status es requerido',
        'status.exists'           => 'El estatus debe existir',
    ];


    public function postSaveObra(Request $request, MapItem $item, IMapper $mapper )
    {
        $method = 'postSaveObra';

        Logger::startMethod($method);

        try {
            if ( ! $request->has('obra')) {
                return response()->json([
                    'status'  => 'Error',
                    'message' => 'Error al recibir el barrio para agregar'
                ]);
            }

            $obra = $request->obra;
            $validator = Validator::make($obra, $this::$rulesSaveObra, $this::$messagesSaveObra);
            if ($validator->fails()) {
                $returnHTML = view('includes.errors')->withErrors($validator)->render();
                return response()->json([
                    'status'  => 'Error',
                    'message' => 'Error de validación',
                    'htmlMessage' => $returnHTML
                ]);
            }

            $obraEntity = $mapper->mapArray(MapItem::class,$obra);

            $id = $this->obraHandler->SaveObra($obraEntity);

            $obraEntity->id = $id;

            if($obra->id == 0)
                $msg = 'Se ha creado la obra correctamente.';
            else
                $msg = 'La obra se ha guardado correctamente.';


            $returnHTML = view('includes.status')->with('status', 'success')
                ->with('message', $msg)->render();
            Logger::endMethod($method);

            return response()->json([
                'status' => 'Ok',
                'data'   => $obraEntity,
                'htmlMessage' => $returnHTML
            ]);
        }
        catch(\Exception $ex)
        {
            return response()->json([
                'status'  => 'Error',
                'message' => $ex->getMessage(),
                'ErrorCode' => $ex->getCode()
            ]);
        }



    }

    public function postDeleteObra(Request $request, MapItem $item, IMapper $mapper )
    {
        $method = 'postSaveObra';

        Logger::startMethod($method);

        try {
            if ( ! $request->has('obraId')) {
                response()->json([
                    'status'  => 'Error',
                    'message' => 'Error al recibir la obra para eliminar'
                ]);
            }

            $obraId = $request->obraId;

           $this->obraHandler->DeleteObra($obraId);

            Logger::endMethod($method);

            return response()->json([
                'status' => 'Ok',
            ]);
        }
        catch(\Exception $ex)
        {
          return  response()->json([
                'status'  => 'Error',
                'message' => $ex->getMessage(),
                'ErrorCode' => $ex->getCode()
            ]);
        }



    }

    public  function  postGetAllObra(Request $request, MapItem $item, IMapper $mapper )
    {
        $method = 'postGetAllObra';
        Logger::startMethod($method);
        try {


            $obras = $this->obraHandler->GetAllObras();


            Logger::endMethod($method);

            return response()->json([
                'status' => 'Ok',
                'data'   => $obras
            ]);
        }
        catch(\Exception $ex)
        {
           return  response()->json([
                'status'  => 'Error',
                'message' => $ex->getMessage(),
                'ErrorCode' => $ex->getCode()
            ]);
        }

    }

    public function postLoadObrasFromFile(Request $request)
    {
        $method = 'postLoadObrasFromFile';
        Logger::startMethod($method);
        try {


            $obras = new Collection();
            if($request->hasFile('importFileCSV'))
            {

                $obrasFile = Excel::load($request->file('importFileCSV'))->get();

                foreach($obrasFile as $obra)
                {
                    $obraValidated = $this->obraHandler->ValidateObraValues($obra);
                    $obraValidated->put('created',0);
                    $obras->push($obraValidated);
                }
            }

            Logger::endMethod($method);
            $returnHTML = view('admin.ObrasBulkLoad',['obras'=>$obras->toArray()])->render();
            return response()->json([
                'status' => 'Ok',
                'data'=> $returnHTML
            ]);


        }
        catch(\Exception $ex)
        {
           return response()->json([
                'status'  => 'Error',
                'message' => $ex->getMessage(),
                'ErrorCode' => $ex->getCode()
            ]);
        }


    }

    public function postSaveObrasFromFile(Request $request)
    {
        $method = 'postSaveObrasFromFile';
        Logger::startMethod($method);
        try {

            if($request->has('chkUpdateEntities'))
            {
                if($request->has('newcpcs'))
                {
                    if(is_array($request->newcpcs)) {
                        foreach ($request->newcpcs as $cpc) {
                            $this->catalogHandler->AddCpc($cpc);
                        }
                    }
                    else
                        $this->catalogHandler->AddCpc($request->newcpcs);

                }

                if($request->has('newbarrios'))
                {
                    if(is_array($request->newbarrios)) {
                        foreach ($request->newbarrios as $barrio) {
                            $this->catalogHandler->AddBarrio($barrio);
                        }
                    }
                    else
                        $this->catalogHandler->AddBarrio($request->newbarrios);
                }

                if($request->has('newcategories'))
                {
                    if(is_array($request->newcategories)) {
                        foreach ($request->newcategories as $category) {
                            $this->catalogHandler->AddCategory($category);
                        }
                    }
                    else
                        $this->catalogHandler->AddCategory($request->newcategories);
                }

            }

            $obras = new Collection();
            $withError = false;
            if($request->has('addObraChk')) {
                for($index = 0 ; $index < count($request->beYear) ; $index++)
                {


                    $obra = collect([
                        'ano' => $request->beYear[$index],
                        'cpc' => $request->beCpc[$index],
                        'barrio' => $request->beBarrio[$index],
                        'categoria' => $request->beCategory[$index],
                        'titulo' => $request->beTitle[$index],
                        'presupuesto' => $request->beBudget[$index],
                        'estado' => $request->beStatus[$index],
                        'ubicacion' =>  $request->beAddress[$index],
                        'location' => $request->beLocation[$index],
                        'nro_expediente' => $request->beNroExpediente[$index],
                        'created' => $request->beCreated[$index]
                    ]);

                    $obra = $this->obraHandler->ValidateObraValues($obra);
                    if($obra['created'] == 2 && $obra['isValid'])
                        $obra['created'] = 0;

                    if(array_has( $request->addObraChk,$index))
                    {

                        if($obra["isValid"] && $obra['created'] == 0 )
                        {
                            $newObra = \App::make(MapItem::class);
                            $newObra->year = $request->beYear[$index];
                            $newObra->description = $request->beTitle[$index];
                            $newObra->address= $request->beAddress[$index];
                            $newObra->budget= $request->beBudget[$index];
                            $newObra->cpc->name = $request->beCpc[$index];
                            $newObra->barrio->name = $request->beBarrio[$index];
                            $newObra->category->category = $request->beCategory[$index];
                            $newObra->status->status = $request->beStatus[$index];
                            $newObra->nro_expediente = $request->beNroExpediente[$index];
                            if(!is_null($request->beLocation[$index]) &&
                                trim($request->beLocation[$index])!='') {
                                $newObra->location= \App::make(GeoPoint::class);
                                $newObra->location->location = $request->beLocation[$index];
                            }

                            $obra['created']=$this->obraHandler->BulkCreateObra($newObra) ? 1 :2 ;
                            if(($obra['created'])==2)
                                $withError = true;

                        }
                        else
                        {
                            $obra['created']=2;
                            $withError = true;
                        }

                    }

                    $obras->push($obra);

                }

            }
            else
            {
                throw new \Exception('No hay ninguna obra seleccionada para grabar.');
            }

            Logger::endMethod($method);

            $returnHTML = view('admin.ObrasBulkLoad',['obras'=>$obras->toArray()])->render();
            return response()->json([
                'status' => 'Ok',
                'data'=> $returnHTML,
                'widthErrors' => $withError
            ]);


        }
        catch(\Exception $ex)
        {
           return  response()->json([
                'status'  => 'Error',
                'message' => $ex->getMessage(),
                'ErrorCode' => $ex->getCode()
            ]);
        }


    }

    public function postGetPosts(Request $request)
    {
        $message = null;
        $method='GetPosts';
        try {

            Logger::startMethod($method);

            if($request->has('obraId')) {
                $obras = $this->postHandler->GetAllPostCompleteByObra($request->obraId);
            }
            else
                throw new \Exception('Error al recibir parámetros de búsqueda para obtener los post');


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

    public function postDeletePhoto(Request $request)
    {
        $method='postDeletePhoto';
        try {

            Logger::startMethod($method);

            if($request->has('photo') && isset($request->photo['id']) && !is_null($request->photo['id']) &&
                isset($request->photo['path']) && !is_null($request->photo['path'])) {
                $obras = $this->postHandler->DeletePhoto($request->photo);
            }
            else
                throw new \Exception('Error al recibir la información de la photo');


            Logger::endMethod($method);

            return response()->json([
                'status' => 'OK',
                'data'   => $obras,
            ]);
        }
        catch(\Exception $ex)
        {
            return  response()->json([
                'status'  => 'ERROR',
                'message' => 'Se ha producido un error al intentar eliminar la foto.'.$ex->getMessage(),
                'ErrorCode' => $ex->getCode()
            ]);
        }

    }

    public function postDeletePost(Request $request)
    {

        $method='postDeletePost';
        try {

            Logger::startMethod($method);

            if($request->has('postId') && $request->postId > 0 ) {
                $obras = $this->postHandler->DeletePost($request->postId);
            }
            else
                throw new \Exception('Error al recibir parámetros de búsqueda para obtener los post');


            Logger::endMethod($method);

            return response()->json([
                'status' => 'OK',
                'data'   => $obras
            ]);
        }
        catch(\Exception $ex)
        {
            return  response()->json([
                'status'  => 'ERROR',
                'message' => 'Se ha producido un error al intentar eliminar el Post.'.$ex->getMessage(),
                'ErrorCode' => $ex->getCode()
            ]);
        }

    }

    public function postMarkAsSpamer(Request $request, AuthHandler $authHandler)
    {

        $method='postMarkAsSpamer';
        try {

            Logger::startMethod($method);

            if($request->has('userId') && $request->userId > 0 ) {
                $authHandler->MarkAsSpamer($request->userId);
            }
            else
                throw new \Exception('Error al recibir parámetro del Usuario');


            Logger::endMethod($method);

            return response()->json([
                'status' => 'OK',
            ]);
        }
        catch(\Exception $ex)
        {
            return  response()->json([
                'status'  => 'ERROR',
                'message' => 'Se ha producido un error al intentar marcar el usuario como spamer.'.$ex->getMessage(),
                'ErrorCode' => $ex->getCode()
            ]);
        }

    }

}
