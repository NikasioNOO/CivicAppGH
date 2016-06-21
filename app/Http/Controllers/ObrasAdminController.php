<?php

namespace CivicApp\Http\Controllers;


use CivicApp\BLL\ObraHandler\ObraHandler;
use CivicApp\Utilities\IMapper;
use CivicApp\Utilities\Logger;
use Illuminate\Http\Request;
use CivicApp\Entities\MapItem\MapItem;
use CivicApp\Http\Requests;
use Gmaps;

class ObrasAdminController extends Controller
{

    private $obraHandler;

    public function __construct(ObraHandler $handler)
    {
        $this->obraHandler = $handler;
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

    public function postSaveObra(Request $request, MapItem $item, IMapper $mapper )
    {
        $method = 'postSaveObra';

        Logger::startMethod($method);

        try {
            if ( ! $request->has('obra')) {
                response()->json([
                    'status'  => 'Error',
                    'message' => 'Error al recibir el barrio para agregar'
                ]);
            }

            $obraEntity = $mapper->mapArray(MapItem::class,$request->obra);

            $id = $this->obraHandler->SaveObra($obraEntity);

            $obraEntity->id = $id;

            Logger::endMethod($method);

            return response()->json([
                'status' => 'Ok',
                'data'   => $obraEntity
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
            response()->json([
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
            response()->json([
                'status'  => 'Error',
                'message' => $ex->getMessage(),
                'ErrorCode' => $ex->getCode()
            ]);
        }




    }
}
