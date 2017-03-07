<?php
/**
 * Created by PhpStorm.
 * User: Nico
 * Date: 30/08/2016
 * Time: 12:19 AM
 */

namespace CivicApp\DAL\Post;


use CivicApp\DAL\Repository\ICriteria;
use CivicApp\DAL\Repository\IRepository;
use CivicApp\Entities;
use CivicApp\Models;

interface IPostRepository extends  IRepository, ICriteria {

    function GetPostsByObraId($obraId, $ordeBy='created_at',$orderType='desc');

    function SavePost(Entities\Post\Post $post );

    function SavePostMarker(Entities\Post\PostMarker $postMarker, $userId , $PostId);

    public function SavePostComplaint(Entities\Post\PostComplaint $postComplaint, $userId , $PostId);

    function GetPostMarker($userId, $postId);

    function SearchCriteria();

    function GetPostsCompleteByObraId($obraId,$ordeBy='created_at',$orderType='desc');

    function DeletePhoto( $id );

    function DeletePost( $id ) ;

    function GetPhotosByPostId($postId);

    function GetPhotosByMapItemId($mapItemId);

}