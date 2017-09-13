<?php
/**
 * Created by PhpStorm.
 * User: Nico
 * Date: 17/05/2016
 * Time: 12:00 AM
 */

namespace CivicApp\Entities\MapItem;


use CivicApp\Entities\Base\BaseEntity;

class MapItemType extends BaseEntity{
    protected $_id;
    protected $_type;

    public function __construct()
    {
        $this->getters = ['id','type'];
        $this->setters = ['id','type'];

        $this->_id = 0;
    }

}