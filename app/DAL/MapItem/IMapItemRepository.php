<?php
/**
 * Created by PhpStorm.
 * User: Nico
 * Date: 19/05/2016
 * Time: 12:29 AM
 */

namespace CivicApp\DAL\MapItem;


use CivicApp\DAL\Repository\ICriteria;
use CivicApp\DAL\Repository\IRepository;
use CivicApp\Entities;

interface IMapItemRepository extends IRepository, ICriteria {

    function UpdateObra(Entities\MapItem\MapItem $obra );

    function SaveObra( $obra );

    function DeleteObra( $id );

    function GetAllObras();

    function GetAllObrasJson();

    function SearchCriteria();

    function GetMapItem($id);

    function UpdateStatusObra($obraId, $statusId);

}