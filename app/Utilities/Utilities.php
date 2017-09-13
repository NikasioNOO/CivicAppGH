<?php
/**
 * Created by PhpStorm.
 * User: Nico
 * Date: 23/05/2016
 * Time: 12:31 AM
 */

namespace CivicApp\Utilities;

use Illuminate\Support\Collection;


class Utilities {

    /**
     * @param $string
     * @param $test
     * Validate if a string end with other substring
     * @return bool
     */
    public static function Endswith($string, $test) {
        $strlen = strlen($string);
        $testlen = strlen($test);
        if ($testlen > $strlen)
            return false;
        return substr_compare($string, $test, $strlen - $testlen, $testlen) === 0;
    }

    public static function GeoCodeAdrress($address, $attempts = 0)
    {

        $lat = 0;
        $lng = 0;

        $status = '';

        try {

            $data_location = "https://maps.google.com/maps/api/geocode/json?key=" . urlencode(env('GMAP_APIKEY')) . "&address=" . urlencode(utf8_encode($address)) . "&bounds=" . urlencode(env('GMAP_BOUNDS'));

            $data = file_get_contents($data_location);

            $data = json_decode($data);

            if ($data->status == "OK") {
                $lat    = $data->results[0]->geometry->location->lat;
                $lng    = $data->results[0]->geometry->location->lng;
                $status = $data->status;
            } else {
                if ($data->status == "OVER_QUERY_LIMIT") {
                    $status = $data->status;
                    if ($attempts < 2) {
                        sleep(1);
                        ++$attempts;
                        $result = Utilities::GeoCodeAdrress($address, $attempts);

                        $lat    = $result['lat'];
                        $lng    = $result['lng'];
                        $status = $result['status'];
                    }
                }
            }
        }
        catch(\Exception $ex)
        {

            Logger::logError('GeoCodeAdrress', $ex->getMessage());

        }

        return  collect(['lat'=>$lat,'lng'=>$lng, 'status'=> $status]);
    }
}