<?php
/**
 * Created by PhpStorm.
 * User: Nico
 * Date: 14/05/2016
 * Time: 10:21 PM
 */

namespace CivicApp\Entities\MapItem;


use CivicApp\Entities\Base\BaseEntity;
use Illuminate\Contracts\Support\Jsonable;

class Category extends BaseEntity {
    protected $_id;
    protected $_category;

    public function __construct()
    {
        $this->setters = ['id','category'];
        $this->getters = ['id','category'];
        $this->_id=0;
    }



}