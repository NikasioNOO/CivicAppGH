<?php

namespace CivicApp\Models\Auth;

use Illuminate\Database\Eloquent\Model;

class Social_User extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['username', 'first_name', 'last_name', 'email', 'avatar', 'provider',
                            'provider_id'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];
}
