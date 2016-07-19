<?php
/**
 * Created by PhpStorm.
 * User: Nico
 * Date: 14/05/2016
 * Time: 09:12 PM
 */

namespace CivicApp\Entities\MapItem;


use CivicApp\Entities\Base\BaseEntity;
use CivicApp\Entities\Common\GeoPoint;

class MapItem extends  BaseEntity{

    protected $_id;
    protected $_year;
    protected $_description;
    protected $_address;
    protected $_budget;
    protected $_cpc;
    protected $_barrio;
    protected $_category;
    protected $_status;
    protected $_mapItemType;
    protected $_location;

    public function __construct(Cpc $cpc, Barrio $barrio, Category $category, Status $status, MapItemType $mapItemType, GeoPoint $location)
    {
        $this->setters = ['id','year','description','address','budget','cpc','barrio','category','status','mapItemType',
            'location'];

        $this->getters = ['id','year','description','address','budget','cpc','barrio','category','status','mapItemType',
            'location'];

        $this->_id= 0;

        $this->_cpc = $cpc;
        $this->_barrio = $barrio;
        $this->_category = $category;
        $this->_status = $status;
        $this->_mapItemType= $mapItemType;
        $this->_location = $location;


    }



}