<?php
/**
 * Created by PhpStorm.
 * User: Nico
 * Date: 25/09/2015
 * Time: 12:12 AM
 */

namespace CivicApp\Entities\Auth;
use Illuminate\Support\Collection;
use CivicApp\Entities;

class SocialUser extends User {


    protected $_avatar;
    protected $_provider;
    protected $_provider_id;
    protected $_is_spamer;
    protected $_password;
    protected $_gender;
    protected $_activated;
    protected $_activation_code;

    public function  __construct()
    {
        $this->setters = ['id'
                        , 'username'
                        , 'gender'
                        , 'first_name'
                        , 'last_name'
                        , 'email'
                        , 'avatar'
                        , 'provider'
                        , 'provider_id'
                        ,'remember_token'
                        ,'is_spamer'
                        ,'password'
                        ,'gender'
                        ,'activated'
                        ,'activation_code'];
        $this->getters = ['id'
                        , 'username'
                        , 'gender'
                        , 'first_name'
                        , 'last_name'
                        , 'email'
                        ,'avatar'
                        ,'provider'
                        ,'provider_id'
                        ,'remember_token'
                        ,'is_spamer'
                        ,'password'
                        ,'gender'
                        ,'activated'
                        ,'activation_code'];

    }

}