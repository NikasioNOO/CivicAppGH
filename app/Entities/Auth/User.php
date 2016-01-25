<?php
/**
 * Created by PhpStorm.
 * User: Nico
 * Date: 13/09/2015
 * Time: 11:45 PM
 */

namespace CivicApp\Entities\Auth;


use CivicApp\Entities\Base\BaseEntity;

class User extends BaseEntity {

    protected $_id;
    protected $_username;
    protected $_first_name;
    protected $_last_name;
    protected $_email;
    protected  $_remember_token;


}