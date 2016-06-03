<?php

namespace CivicApp\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table= 'categories';
    protected $fillable=['category'];
    public function mapItems()
    {
        return $this->hasMany(MapItem::class);
    }

}
