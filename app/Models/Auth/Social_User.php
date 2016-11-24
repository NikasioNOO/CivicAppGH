<?php

namespace CivicApp\Models\Auth;

use CivicApp\Models\Post;
use CivicApp\Models\PostComplaint;
use CivicApp\Models\PostMarker;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Auth\Authenticatable;

class Social_User extends Model implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    protected $table='social_users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['username','gender', 'first_name', 'last_name', 'email', 'avatar', 'provider',
                            'provider_id','is_spamer','remember_token', 'activated', 'activation_code'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [ 'remember_token'];


    public function Posts()
    {
        return $this->hasMany(Post::class,'user_id');
    }

    public function PostMarkers()
    {
        return $this->hasMany(PostMarker::class,'user_id');
    }

    public function PostComplaints()
    {
        return $this->hasMany(PostComplaint::class,'user_id');
    }
}
