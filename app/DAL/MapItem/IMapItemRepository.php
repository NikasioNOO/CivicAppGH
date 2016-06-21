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

    public function UpdateObra(Entities\MapItem\MapItem $obra );

    public function SaveObra( $obra );

    public function DeleteObra( $id );

    public  function GetAllObras();

    public function SearchCriteria();

    public function GetMapItem($id);

}