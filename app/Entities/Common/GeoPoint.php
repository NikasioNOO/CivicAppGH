<?php
/**
 * Created by PhpStorm.
 * User: Nico
 * Date: 17/05/2016
 * Time: 12:03 AM
 */

namespace CivicApp\Entities\Common;


use CivicApp\Entities\Base\BaseEntity;

class GeoPoint extends BaseEntity {

    protected $_id;
    protected $_location;

    public function __construct()
    {
        $this->getters=['id','location'];
        $this->setters=['id','location'];
        $this->_id = 0;
    }

}