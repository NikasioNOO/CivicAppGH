<?php
/**
 * Created by PhpStorm.
 * User: Nico
 * Date: 23/05/2016
 * Time: 12:31 AM
 */

namespace CivicApp\Utilities;


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
}