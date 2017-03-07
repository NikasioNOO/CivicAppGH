<?php
/**
 * Created by PhpStorm.
 * User: Nico
 * Date: 30/08/2016
 * Time: 12:28 AM
 */

namespace CivicApp\Entities\Post;


use CivicApp\Entities\Base\BaseEntity;

class PostType extends BaseEntity {
    protected $_id;
    protected $_post_type;

    public function __construct()
    {
        $this->_id = 0;
        $this->getters = ['id','post_type'];
        $this->setters = ['id','post_type'];
    }


}