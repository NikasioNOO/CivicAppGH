<?php
/**
 * Created by PhpStorm.
 * User: Nico
 * Date: 21/11/2015
 * Time: 11:10 PM
 */

namespace CivicApp\Utilities;


use PhpParser\Node\Scalar\String_;

class Logger {
    public static function startMethod($method)
    {
        \Log::info("Inicio ".$method);
    }
    public static function endMethod($method)
    {

        \Log::info("Fin ".$method);
    }

    public static function logError($method, $menssage)
    {

        \Log::error("Error en: ".$method. " Mensaje:".$menssage);
    }
}