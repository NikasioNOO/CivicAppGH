<?php

namespace CivicApp\Models;

use Illuminate\Database\Eloquent\Model;

class MapItemType extends Model
{
    protected $table="map_item_types";
    protected $fillable=['type'];
    public function mapItems()
    {
        return $this->hasMany(MapItem::class,'map_item_type_id');
    }
}
