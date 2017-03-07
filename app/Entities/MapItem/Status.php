<?php
/**
 * Created by PhpStorm.
 * User: Nico
 * Date: 16/05/2016
 * Time: 11:53 PM
 */

namespace CivicApp\Entities\MapItem;


use CivicApp\Entities\Base\BaseEntity;

class Status extends BaseEntity {

    protected $_id;
    protected $_status;

    public function __construct()
    {
        $this->setters = ['id','status'];
        $this->getters = ['id','status'];
        $this->_id=0;
    }

}