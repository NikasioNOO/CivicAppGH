<?php
/**
 * Created by PhpStorm.
 * User: Nico
 * Date: 30/08/2016
 * Time: 12:33 AM
 */

namespace CivicApp\Entities\Post;


use CivicApp\Entities\Base\BaseEntity;

class PostMarker extends BaseEntity {
    protected $_id;
    protected $_is_positive;
    protected $_user_id;


    public function __construct(){
        $this->getters= ['id','is_positive','user_id'];
        $this->setters = ['id','is_positive','user_id'];
        $this->_id = 0;
        $this->_is_positive = false;

    }

}