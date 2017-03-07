<?php
/**
 * Created by PhpStorm.
 * User: Nico
 * Date: 16/05/2016
 * Time: 11:56 PM
 */

namespace CivicApp\Entities\MapItem;


use CivicApp\Entities\Base\BaseEntity;

class Barrio extends BaseEntity{
    protected $_id;
    protected $_name;
    protected $_location;

    public function __construct()
    {
        $this->setters = ['id','name','location'];
        $this->getters = ['id','name','location'];
        $this->_id = 0;
    }
}