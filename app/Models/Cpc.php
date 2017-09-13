<?php

namespace CivicApp\Models;

use Illuminate\Database\Eloquent\Model;

class Cpc extends Model
{
    protected $table='cpc';
    protected $fillable=['name'];


    public function mapItems()
    {
        return $this->hasMany(MapItem::class);
    }
}
