<?php

namespace CivicApp\Models\Auth;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class App_User extends Model implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract
{

    use Authenticatable, Authorizable, CanResetPassword;

    protected $table='app_users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     *
     */

    protected $fillable = ['username', 'first_name', 'last_name', 'email', 'password', 'remember_token'];

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

    public function hasRole($name)
    {
        foreach($this->roles as $role)
        {
            if($role->role_name == $name) return true;
        }

        return false;
    }
}
