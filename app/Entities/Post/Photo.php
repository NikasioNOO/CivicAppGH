<?php
/**
 * Created by PhpStorm.
 * User: Nico
 * Date: 30/08/2016
 * Time: 12:29 AM
 */

namespace CivicApp\Entities\Post;


use CivicApp\Entities\Base\BaseEntity;

class Photo extends BaseEntity {
    protected $_id;
    protected $_comment;
    protected $_path;

    public function __construct()
    {
        $this->getters = ['id','comment','path'];
        $this->setters = ['id','comment','path'];
        $this->_id=0;
    }

}