<?php

namespace CivicApp\Http\Controllers;

use Illuminate\Http\Request;

use CivicApp\Http\Requests;
use Gmaps;

class ObrasAdminController extends Controller
{
    //
    public  function getIndex()
    {
        $config = array();
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

        $dircasa = Gmaps::get_lat_long_from_address('Mariano Fragueiro 1011, Córdoba, Argentina');

        Gmaps::initialize($config);

        // set up the marker ready for positioning
        // once we know the users location
        $marker = array();
        Gmaps::add_marker($marker);

        $map = Gmaps::create_map();

        return view('admin.obraspresupuesto', ['map' => $map]);


    }
}
