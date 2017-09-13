<?php

namespace CivicApp\Models;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $table='photos';

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
