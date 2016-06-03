<?php

namespace CivicApp\Models;

use CivicApp\Models\Auth\Social_User;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table='posts';

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

    public function posMarkers()
    {
        return $this->hasMany(PostMarker::class);
    }


    public function postComplaints()
    {
        return $this->hasMany(PostComplaint::class);
    }



}
