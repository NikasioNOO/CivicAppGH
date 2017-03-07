<?php

namespace CivicApp\Models;

use CivicApp\Models\Auth\Social_User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Post extends Model
{
    protected $table='posts';

    protected $appends = ['positive_count','negative_count'];

    protected $visible = ['positive_count','negative_count'];


    public function mapItem()
    {
        return $this->belongsTo(MapItem::class,'map_item_id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function postType()
    {
        return $this->belongsTo(PostType::class,'post_type_id');

    }

    public function user()
    {
        return $this->belongsTo(Social_User::class,'user_id');
    }

    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

    public function postMarkers()
    {
        return $this->hasMany(PostMarker::class);
    }


    public function postComplaints()
    {
        return $this->hasMany(PostComplaint::class);
    }

    public function positiveCount()
    {
        return $this->hasOne(PostMarker::class)
            ->selectRaw('post_id, count(*) as aggregate')
            ->where('is_positive','=',1)
            ->groupBy('post_id');
    }

    public function getPositiveCountAttribute()
    {
        if ( ! $this->relationLoaded('positiveCount') )
            $this->load('positiveCount');

        $related = $this->getRelation('positiveCount');

        // then return the count directly
        return ($related) ? (int) $related->aggregate : 0;
    }

    public function getNegativeCountAttribute()
    {
        if ( ! $this->relationLoaded('positiveCount') )
            $this->load('positiveCount');

        $related = $this->getRelation('positiveCount');

        // then return the count directly
        return ($related) ? (int) ($this->post_markers_count - $related->aggregate ): 0;
    }





}
