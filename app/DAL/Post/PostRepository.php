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
use Illuminate\Support\Facades\DB;

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

    private  $obraId ;
    public function GetPostsByObraId($obraId)
    {
        $method = "GetPostsByObraId";
        try {
            $this->obraId = $obraId;
            Logger::startMethod($method);



            $posts =  Models\Post::with('status','postType','user','photos','postMarkers','postComplaints','positiveCount')
                ->whereHas('mapItem',function($query){
                    $query->where('id',$this->obraId);
                })->withCount('postMarkers')
                ->orderBy('created_at','desc')
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

}