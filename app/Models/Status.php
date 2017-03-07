<?php

namespace CivicApp\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $table='statuses';
    protected $fillable = ['status'];

    public function mapItems()
    {
        return $this->hasMany(MapItem::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }


}
