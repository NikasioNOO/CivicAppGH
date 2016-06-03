<?php
/**
 * Created by PhpStorm.
 * User: Nico
 * Date: 14/05/2016
 * Time: 09:12 PM
 */

namespace CivicApp\Entities\MapItem;


use CivicApp\Entities\Base\BaseEntity;

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

    public function __construct()
    {
        $this->setters = ['id','year','description','address','budget','cpc','barrio','category','status','mapItemType',
            'location'];

        $this->getters = ['id','year','description','address','budget','cpc','barrio','category','status','mapItemType',
            'location'];

        $this->_id= 0;

    }



}