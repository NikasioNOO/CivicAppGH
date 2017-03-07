<?php

namespace CivicApp\Models;

use CivicApp\Models\Auth\Social_User;
use Illuminate\Database\Eloquent\Model;

class PostMarker extends Model
{
    protected $table='post_markers';

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function user()
    {
        return $this->belongsTo(Social_User::class,'user_id');
    }
}
