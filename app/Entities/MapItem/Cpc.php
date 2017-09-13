<?php
/**
 * Created by PhpStorm.
 * User: Nico
 * Date: 16/05/2016
 * Time: 11:31 PM
 */

namespace CivicApp\Entities\MapItem;


use CivicApp\Entities\Base\BaseEntity;

class Cpc extends BaseEntity {
    protected $_id;
    protected $_name;

    public function __construct()
    {
        $this->setters = ['id','name'];
        $this->getters = ['id','name'];
        $this->_id=0;
    }
}