<?php

namespace CivicApp\Models;

use Illuminate\Database\Eloquent\Model;

class MapItem extends Model
{
    protected $table='map_items';

    protected $guarded=[''];

    protected  $fillable =['year','description','address','budget'];
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function mapItemType()
    {
        return $this->belongsTo(MapItemType::class,'map_item_type_id');
    }

    public function barrio()
    {
        return $this->belongsTo(Barrio::class);
    }


    public function cpc()
    {
        return $this->belongsTo(Cpc::class);
    }



    public function location()
    {
        return $this->belongsTo(GeoPoint::class,'geo_point_id');
    }

    public function posts()
    {
        return $this->hasMany(Post::class,'map_item_id');
    }


}
