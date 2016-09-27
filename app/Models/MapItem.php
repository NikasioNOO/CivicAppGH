<?php

namespace CivicApp\Models;

use Illuminate\Database\Eloquent\Model;

class MapItem extends Model
{
    protected $table='map_items';

    protected $guarded=[''];

    protected  $fillable =['year','description','address','budget', 'nro_expediente'];
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

    public function postComplaintsCounts()
    {

        $test = $this->hasOne(Post::class)
                    ->join('post_complaints','posts.id','=', 'post_complaints.post_id')
                    ->selectRaw('map_item_id, count(*) as aggregate')
                    ->groupBy('map_item_id');


        /*if ( ! $this->relationLoaded('posts') )
            $this->load('posts');

        $related = $this->getRelation('posts');*/

        return $test; // $related->count() > 0 ? $related->postComplaints()->count() : 0;


    }

    public function getpostComplaintsCountsAttribute()
    {
        if ( ! $this->relationLoaded('postComplaintsCounts') )
            $this->load('postComplaintsCounts');

        $related = $this->getRelation('postComplaintsCounts');

        // then return the count directly
        return ($related) ? (int) $related->aggregate : 0;
    }


}
