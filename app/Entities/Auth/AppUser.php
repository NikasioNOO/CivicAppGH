<?php
/**
 * Created by PhpStorm.
 * User: Nico
 * Date: 11/09/2015
 * Time: 12:59 AM
 */

namespace CivicApp\Entities\Auth;
use Illuminate\Support\Collection;
use CivicApp\Entities;

class AppUser extends User {



    protected  $_password;


    protected  $_roles;



    public function  __construct(Collection $roles)
    {

        $this->setters = ['id', 'username', 'first_name', 'last_name', 'email', 'password',
                        'remember_token','roles'];
        $this->getters = ['id', 'username', 'first_name', 'last_name', 'email', 'password',
                            'remember_token', 'roles'];
        $this->_roles =$roles;


    }

    protected function _fullname()
    {
        return $this->_first_name. " ".$this->_last_name;

    }

    /*protected  function  _roles($role)
    {
        if(!$role instanceof Role)
            throw new Entities\EntityIlegalException('Ilegal Object set to attribute, it must be CivicApp\Entities\Auth\Role');

    }*/

}