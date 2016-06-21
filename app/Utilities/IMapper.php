<?php
/**
 * Created by PhpStorm.
 * User: Nico
 * Date: 05/12/2015
 * Time: 04:12 PM
 */
namespace CivicApp\Utilities;

interface IMapper
{
    public function addMap($fromClass, $toClass, $typeMapper);

    public function map($fromClass, $toClass, $obj);

    public function addCustomMap($classFrom, $classTo, $callbackCustom);

    public function addCustomMapArray($classTo, $callbackCustom);

    public function mapArray($toClass, $array);
}