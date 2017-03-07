<?php

namespace CivicApp\Models\Auth;

use Illuminate\Database\Eloquent\Model;

class Page_Config extends Model
{
    public  function  roles()
    {
        return $this->belongsToMany('CivicApp\Models\Auth\Roles','roles_page_config',
            'page_config_id','role_id');
    }
}
