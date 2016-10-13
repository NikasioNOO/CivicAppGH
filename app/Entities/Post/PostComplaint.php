<?php
/**
 * Created by PhpStorm.
 * User: Nico
 * Date: 30/08/2016
 * Time: 12:34 AM
 */

namespace CivicApp\Entities\Post;


use CivicApp\Entities\Base\BaseEntity;

class PostComplaint extends BaseEntity {
    protected $_id;
    protected $_comment;
    protected $_user;
    protected $_created_at;

    public function __construct()
    {
        $this->getters = ['id','comment','user','created_at'];
        $this->setters = ['id','comment','user','created_at'];

        $this->_id = 0;
    }
}