<?php

namespace CivicApp\Models\Auth;

use Illuminate\Database\Eloquent\Model;

class App_User extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['username', 'first_name', 'last_name', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public  function  roles()
    {
        return $this->belongsToMany('CivicApp\Models\Auth\Role','app_user_role',
                                    'app_user_id', 'role_id');
    }
}
