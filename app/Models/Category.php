<?php

namespace CivicApp\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table= 'categories';
    protected $fillable=['category','images'];
    public function mapItems()
    {
        return $this->hasMany(MapItem::class);
    }

}
