<?php
/**
 * Created by PhpStorm.
 * User: Nico
 * Date: 30/08/2016
 * Time: 12:22 AM
 */

namespace CivicApp\Entities\Post;


use CivicApp\Entities\Auth\SocialUser;
use CivicApp\Entities\Base\BaseEntity;
use CivicApp\Entities\MapItem\MapItem;
use CivicApp\Entities\MapItem\Status;
use Illuminate\Support\Collection;

class Post extends BaseEntity {

    protected $_id;
    protected $_comment;
    protected $_mapItem;
    protected $_status;
    protected $_postType;
    protected $_user;
    protected $_photos;
    protected $_postMarkers;
    protected $_postComplaints;
    protected $_post_markers_count;
    protected $_positiveCount;
    protected $_negativeCount;
    protected $_post_complaints_count;
    protected $_created_at;
    private $user_id;
    public function __construct(MapItem $mapItem,  Status $status, PostType $postType
        , SocialUser $user, Collection $photosParam, Collection $postMarkersParam, Collection $postComplaintsParam)
    {
        $this->_id = 0;
        $this->getters=['id','comment','mapItem','status','postType','user',
            'photos','postMarkers','postComplaints','post_markers_count','positiveCount','negativeCount','created_at','post_complaints_count'];
        $this->setters=['id','comment','mapItem','status','postType','user',
            'photos','postMarkers','postComplaints','post_markers_count','positiveCount','negativeCount','created_at','post_complaints_count'];
        $this->_postType = $postType;
        $this->_postType->id = 1;  // Generico
        $this->_mapItem = $mapItem;
      //  $this->_status = $status;
        $this->_user = $user;
        $this->_photos = $photosParam;
        $this->_postMarkers = $postMarkersParam;
        $this->_postComplaints = $postComplaintsParam;
    }

    public function UserMarkPost($userId)
    {
        $this->user_id=$userId;

        $result= $this->_postMarkers->search(function ($item, $key) {
            return $item->user_id == $this->user_id;
        });

        if( is_numeric($result))
            return true;
        else
            return false;
    }

}