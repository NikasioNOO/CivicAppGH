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
    protected $_images;

    public function __construct()
    {
        $this->setters = ['id','category','images'];
        $this->getters = ['id','category','images'];
        $this->_id=0;
    }



}