<?php

namespace CivicApp\Models\Auth;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['role_name'];

    public  function  users()
    {
        return $this->belongsToMany('CivicApp\Models\Auth\App_User','app_user_role',
                 'role_id','app_user_id');
    }

    public  function  pages()
    {
        return $this->belongsToMany('CivicApp\Models\Auth\Page_Config','roles_page_config',
            'role_id','page_config_id');
    }

}
