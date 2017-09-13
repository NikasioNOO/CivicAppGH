<?php

namespace CivicApp\Models;

use Illuminate\Database\Eloquent\Model;

class Barrio extends Model
{

    protected $table='barrios';

    protected $fillable=['name'];
    public function mapItems()
    {
        return $this->hasMany(MapItem::class);
    }

    public function location()
    {
        return $this->belongsTo(GeoPoint::class,'geo_point_id');
    }
}
