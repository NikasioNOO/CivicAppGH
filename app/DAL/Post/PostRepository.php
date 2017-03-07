<?php
/**
 * Created by PhpStorm.
 * User: Nico
 * Date: 29/08/2016
 * Time: 10:03 PM
 */

namespace CivicApp\DAL\Post;


use CivicApp\DAL\Repository\Repository;
use CivicApp\DAL\Repository\RepositoryException;
use CivicApp\Models;
use CivicApp\Entities;
use CivicApp\Models\Photo;
use CivicApp\Utilities\Logger;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Exception;
use DB;

class PostRepository extends Repository implements IPostRepository {

    /**
     * Specify Model class name
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    function model()
    {
        return Models\Post::class;
    }


    protected function entity()
    {
        return Entities\Post\Post::class;
    }

    private  $mapItemId ;

    public function GetPostsByObraId($obraId,$ordeBy='created_at',$orderType='desc')
    {
        $method = "GetPostsByObraId";
        try {
            $this->mapItemId = $obraId;
            Logger::startMethod($method);



            $posts =  Models\Post::with('status','postType','user','photos',
                //'postMarkers','postComplaints',
                'positiveCount')
                ->whereHas('mapItem',function($query){
                    $query->where('id',$this->mapItemId);
                })->withCount('postMarkers')
                ->withCount('postComplaints')
                ->orderBy($ordeBy,$orderType)
                ->get();


            $postsEntities = $this->mapper->map(Models\Post::class, Entities\Post\Post::class, $posts->all());

            Logger::endMethod($method);

            return $postsEntities;
        }
        catch(QueryException $ex)
        {
            Logger::logError($method, $ex->errorInfo.'.STACKTRACE:'.$ex->getTraceAsString());
            throw new RepositoryException(trans('posterrorcodes.0102'),0102);
        }
        catch(Exception $ex)
        {
            Logger::logError($method, $ex->getMessage().'.STACKTRACE:'.$ex->getTraceAsString());
            throw new RepositoryException(trans('mapitemserrorcodes.0102'),0102);
        }
    }

    public function GetPostsCompleteByObraId($obraId,$ordeBy='created_at',$orderType='desc')
    {
        $method = "GetPostsCompleteByObraId";
        try {
            $this->mapItemId = $obraId;
            Logger::startMethod($method);



            $posts =  Models\Post::with('status','postType','user','photos','postComplaints'
                ,'positiveCount','postComplaints.user')
                ->whereHas('mapItem',function($query){
                    $query->where('id',$this->mapItemId);
                })->withCount('postMarkers')
                ->withCount('postComplaints')
                ->orderBy($ordeBy,$orderType)
                ->get();


            $postsEntities = $this->mapper->map(Models\Post::class, Entities\Post\Post::class, $posts->all());
            if(!is_null($posts) && $posts->count() > 0) {
                for ($i = 0; $i< $posts->count(); $i++)
                {
                    $postsEntities[$i]->postComplaints = $postsEntities[$i]->postComplaints->merge($this->mapper->map(Models\PostComplaint::class,
                        Entities\Post\PostComplaint::class, $posts[$i]->postComplaints->all()));
                }
            }

            Logger::endMethod($method);

            return $postsEntities;
        }
        catch(QueryException $ex)
        {
            Logger::logError($method, $ex->errorInfo.'.STACKTRACE:'.$ex->getTraceAsString());
            throw new RepositoryException(trans('posterrorcodes.0102'),0102);
        }
        catch(Exception $ex)
        {
            Logger::logError($method, $ex->getMessage().'.STACKTRACE:'.$ex->getTraceAsString());
            throw new RepositoryException(trans('mapitemserrorcodes.0102'),0102);
        }
    }



    /**
     * @param Entities\Post\Post $post
     */
    public function SavePost(Entities\Post\Post $post )
    {
        $method = 'SavePost';
        Logger::startMethod($method);
        try {
         //   DB::beginTransaction();
            /** @var Models\Post $post */
            $post = $this->mapper->map($this->entity(), $this->model(), $post);



            if($post->id==0 && isset($post->photos) && $post->photos->count()> 0)
            {
                $post->save();
                /** @var Photo $photo */
                foreach($post->photos as $photo)
                {
                    $photo->post()->associate($post->id);
                    $photo->save();
                }
            }
            else
                $post->save();

        //    DB::commit();

            Logger::endMethod($method);

            return $this->mapper->map($this->model(),$this->entity(),$post);
        }
        catch(QueryException $ex)
        {
          //  DB::rollBack();
            Logger::logError($method, $ex->errorInfo.'.STACKTRACE:'.$ex->getTraceAsString());

            throw new RepositoryException(trans('posterrorcodes.0100'),0100);

        }
        catch(Exception $ex)
        {
            //DB::rollBack();
            Logger::logError($method, $ex->getMessage().'.STACKTRACE:'.$ex->getTraceAsString());

            throw new RepositoryException(trans('posterrorcodes.0100'),0100);

        }

    }

    public function GetPostMarker($userId, $postId)
    {
        $method = 'GetPostMarker';
        try{
            Logger::startMethod($method);
            $postMarker = Models\PostMarker::where('post_id',$postId)->where('user_id',$userId)->get();

            if(is_null($postMarker) || $postMarker->count() ==0)
                return null;
            else
                return $this->mapper->map(Models\PostMarker::class,Entities\Post\PostMarker::class,$postMarker->all());
        }
        catch(QueryException $ex)
        {
            Logger::logError($method, $ex->errorInfo.'.STACKTRACE:'.$ex->getTraceAsString());


            throw new RepositoryException(trans('posterrorcodes.0104'));
        }
        catch(Exception $ex)
        {

            Logger::logError($method, $ex->getMessage().'.STACKTRACE:'.$ex->getTraceAsString());

            throw new RepositoryException(trans('posterrorcodes.0104'));

        }
    }

    public function SavePostMarker(Entities\Post\PostMarker $postMarker, $userId , $PostId)
    {
        $method = 'SavePostMarker';
        Logger::startMethod($method);
        try {
            DB::beginTransaction();
            /** @var Models\PostMarker $postMarkerModel */
            $postMarkerModel = $this->mapper->map(Entities\Post\PostMarker::class, Models\PostMarker::class, $postMarker);

            $postMarkerModel->post()->associate($PostId);
            $postMarkerModel->user()->associate($userId);

            $postMarkerModel->save();

            DB::commit();

            Logger::endMethod($method);

            return $postMarkerModel->id;
        }
        catch(QueryException $ex)
        {
            DB::rollBack();
            Logger::logError($method, $ex->errorInfo.'.STACKTRACE:'.$ex->getTraceAsString());

            throw new RepositoryException(trans('posterrorcodes.0100'),0100);

        }
        catch(Exception $ex)
        {
            DB::rollBack();
            Logger::logError($method, $ex->getMessage().'.STACKTRACE:'.$ex->getTraceAsString());

            throw new RepositoryException(trans('posterrorcodes.0100'),0100);

        }
    }

    public function SavePostComplaint(Entities\Post\PostComplaint $postComplaint, $userId , $PostId)
    {
        $method = 'SavePostMarker';
        Logger::startMethod($method);
        try {
            DB::beginTransaction();
            /** @var Models\PostComplaint $postComplaintModel */
            $postComplaintModel = $this->mapper->map(Entities\Post\PostComplaint::class, Models\PostComplaint::class, $postComplaint);

            $postComplaintModel->post()->associate($PostId);
            $postComplaintModel->user()->associate($userId);

            $postComplaintModel->save();

            DB::commit();

            Logger::endMethod($method);

            return $postComplaintModel->id;
        }
        catch(QueryException $ex)
        {
            DB::rollBack();
            Logger::logError($method, $ex->errorInfo.'.STACKTRACE:'.$ex->getTraceAsString());

            throw new RepositoryException(trans('posterrorcodes.0100'),0100);

        }
        catch(Exception $ex)
        {
            DB::rollBack();
            Logger::logError($method, $ex->getMessage().'.STACKTRACE:'.$ex->getTraceAsString());

            throw new RepositoryException(trans('posterrorcodes.0100'),0100);

        }
    }

    public function SearchCriteria()
    {
        $method = "SearchCriteria";
        try {

            Logger::startMethod($method);

            $obras = $this->all();

            $obrasEntities = $this->mapper->map($this->model(), $this->entity(), $obras->all());

            Logger::endMethod($method);

            return $obrasEntities;
        }
        catch(QueryException $ex)
        {
            Logger::logError($method, $ex->getMessage().$ex->getSql() );
            throw new RepositoryException(trans('posterrorcodes.0102'));
        }
        catch(Exception $ex)
        {
            Logger::logError($method, $ex->getMessage());
            throw new RepositoryException(trans('posterrorcodes.0102'));
        }

    }

    public function DeletePhoto( $id )
    {
        $method = 'DeletePhoto';
        Logger::startMethod($method);
        try {

            $photo = Photo::find($id);

            $photo->delete();

            Logger::endMethod($method);


        }
        catch(QueryException $ex)
        {
            Logger::logError($method, $ex->getMessage());

            throw new RepositoryException(trans('posterrorcodes.0106'));

        }
        catch(Exception $ex)
        {

            Logger::logError($method, $ex->getMessage());

            throw new RepositoryException(trans('posterrorcodes.0106'));

        }

    }




    public function DeletePost( $id )
    {
        $method = 'DeletePhoto';
        Logger::startMethod($method);
        try {

            $post = $this->model->find($id);

            $post->delete();

            Logger::endMethod($method);


        }
        catch(QueryException $ex)
        {
            Logger::logError($method, $ex->getMessage());

            throw new RepositoryException(trans('posterrorcodes.0106'));

        }
        catch(Exception $ex)
        {
            Logger::logError($method, $ex->getMessage());

            throw new RepositoryException(trans('posterrorcodes.0106'));

        }

    }


    public function GetPhotosByPostId($postId)
    {
        $method = 'GetPhotosByPostId';
        try{
            Logger::startMethod($method);
            $photos = Photo::where('post_id',$postId)->get();

            if(is_null($photos) || $photos->count() ==0)
                return null;
            else
                return $this->mapper->map(Models\Photo::class,Entities\Post\Photo::class,$photos->all());
        }
        catch(QueryException $ex)
        {
            Logger::logError($method, $ex->errorInfo.'.STACKTRACE:'.$ex->getTraceAsString());


            throw new RepositoryException(trans('posterrorcodes.0107'));
        }
        catch(Exception $ex)
        {

            Logger::logError($method, $ex->getMessage().'.STACKTRACE:'.$ex->getTraceAsString());

            throw new RepositoryException(trans('posterrorcodes.0107'));

        }
    }


    /**
     * @param $mapItemId
     *
     * @return null
     * @throws RepositoryException
     */
    public function GetPhotosByMapItemId($mapItemId)
    {
        $method = 'GetPhotosByMapItemId';
        try{
            Logger::startMethod($method);
            $this->mapItemId = $mapItemId;
            $photos = Photo::with('post')->whereHas('post',function($query){
                $query->where('map_item_id',$this->mapItemId);
            })->get();

            if(is_null($photos) || $photos->count() ==0)
                return null;
            else
                return $this->mapper->map(Models\Photo::class,Entities\Post\Photo::class,$photos->all());
        }
        catch(QueryException $ex)
        {
            Logger::logError($method, $ex->errorInfo.'.STACKTRACE:'.$ex->getTraceAsString());


            throw new RepositoryException(trans('posterrorcodes.0108'));
        }
        catch(Exception $ex)
        {

            Logger::logError($method, $ex->getMessage().'.STACKTRACE:'.$ex->getTraceAsString());

            throw new RepositoryException(trans('posterrorcodes.0108'));

        }
    }
}