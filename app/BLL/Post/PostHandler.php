<?php
/**
 * Created by PhpStorm.
 * User: Nico
 * Date: 02/09/2016
 * Time: 12:54 PM
 */

namespace CivicApp\BLL\Post;


use CivicApp\BLL\Obra\ObraHandler;
use CivicApp\BLL\Auth\AuthHandler;
use CivicApp\DAL\Catalog\ICatalogRepository;
use CivicApp\DAL\Post\Criterias\PostsByObra;
use CivicApp\DAL\Post\IPostRepository;
use CivicApp\DAL\MapItem\IMapItemRepository;
use CivicApp\DAL\Repository\RepositoryException;
use CivicApp\Entities;
use CivicApp\Utilities\Logger;
use File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use DB;
use Image;
use Storage;

class PostHandler {

    /** @var  IPostRepository $postRepository */
    private $postRepository;
    /** @var  ObraHandler $obraHandler */
    private $obraHandler;
    /** @var  ICatalogRepository $catalogRepository */
    private $catalogRepository;
    /** @var  AuthHandler $authHandler*/
    private $authHandler;

    public function __construct(IPostRepository $postRepo, ICatalogRepository $catalogRepo, ObraHandler $obraH, AuthHandler $authH){
        $this->postRepository = $postRepo;
        $this->obraHandler = $obraH;
        $this->catalogRepository = $catalogRepo;
        $this->authHandler = $authH;
    }

    public function GetAllPostByObra($obraId, $orderBy='created_at', $orderType='desc')
    {
        $method = 'GetAllPostByObra';
        try{
            Logger::startMethod($method);


            if(is_null($this->obraHandler->GetObra($obraId)))
                throw new PostValidationException(trans('posterrorcodes.0301',['id'=>$obraId]),300);

            Logger::endMethod($method);

            return $this->postRepository->GetPostsByObraId($obraId, $orderBy, $orderType);

        }
        catch(PostValidationException $ex)
        {
            Logger::logError($method, $ex->getMessage().'.STACKTRACE:'.$ex->getTraceAsString());
            throw $ex;
        }


    }

    public function GetAllPostCompleteByObra($obraId, $orderBy='created_at', $orderType='desc')
    {
        $method = 'GetAllPostByObra';
        try{
            Logger::startMethod($method);


            if(is_null($this->obraHandler->GetObra($obraId)))
                throw new PostValidationException(trans('posterrorcodes.0301',['id'=>$obraId]),300);

            Logger::endMethod($method);

            return $this->postRepository->GetPostsCompleteByObraId($obraId, $orderBy, $orderType);

        }
        catch(PostValidationException $ex)
        {
            Logger::logError($method, $ex->getMessage().'.STACKTRACE:'.$ex->getTraceAsString());
            throw $ex;
        }


    }

    public function SavePost(Entities\Post\Post $post )
    {
        $method = 'SavePost';

        Logger::startMethod($method);
        try {
            DB::beginTransaction();
            $statusChange = false;
            $obraDB = $this->ValidatePost($post);

            $postSaved = $this->postRepository->SavePost($post);

            if ( ! is_null($post->status) && $obraDB->status->id != $post->status->id) {
                $statusChange = true;
               $this->obraHandler->UpdateStatusObra($post->mapItem->id,$post->status->id);
            }

            DB::commit();
            Logger::endMethod($method);

            return ['statusChange'=>$statusChange, 'post'=>$postSaved];

        }catch (\Exception $ex)
        {
            DB::rollBack();
            throw $ex;

        }

    }

    public function DeletePost($postId)
    {
        $method = 'DeletePost';

        Logger::startMethod($method);
        try {
            DB::beginTransaction();

            $post  = $this->postRepository->findById($postId);

            if(is_null($post))
                throw new PostValidationException(trans('posterrorcodes.0309'));

            $photos = $this->postRepository->GetPhotosByPostId($postId);
            $this->postRepository->DeletePost($postId);

            $deleteflag = true;
            if(!is_null($photos) && count($photos) > 0) {
                foreach ($photos as $photo) {
                    if ( ! $this->DeletePhysicalPhoto($photo->path)) {
                        $deleteflag = false;
                    }

                }
            }

            DB::commit();
            Logger::endMethod($method);
            return $deleteflag;


        }catch (\Exception $ex)
        {
            DB::rollBack();
            throw $ex;

        }

    }



    private function ValidatePost(Entities\Post\Post $post)
    {
        $method = 'ValidatePost';
        Logger::startMethod($method);

        if(is_null($post))
            throw new PostValidationException(trans('posterrorcodes.0300'));

        if(empty(trim($post->comment)))
            throw new PostValidationException(trans('posterrorcodes.0302'));

        $obraDB = $this->obraHandler->GetObra($post->mapItem->id);
        if(is_null($post->mapItem) || is_null($obraDB))
            throw new PostValidationException(trans('posterrorcodes.0301',['id'=>$post->mapItem->id]),300);

        if(!is_null($post->status) &&  is_null($this->catalogRepository->GetStatus($post->status->id)))
            throw new PostValidationException(trans('posterrorcodes.0303',['catalog'=>'El Estado']));

        if(!is_null($post->postType) && is_null($this->catalogRepository->GetPostType($post->postType->id)))
            throw new PostValidationException(trans('posterrorcodes.0303',['catalog'=>'El Tipo de Post']));

        if(is_null($post->user) || !$this->authHandler->UserExists($post->user->id))
            throw new PostValidationException(trans('posterrorcodes.0303',['catalog'=>'El usuario']));

        Logger::endMethod($method);
        return $obraDB;

    }

    public function SavePostMarker(Entities\Post\PostMarker $postMarker, $userId, $postId)
    {
        $method = 'SavePostMarker';

        Logger::startMethod($method);

        if( is_null($userId) || !$this->authHandler->UserExists($userId))
            throw new PostValidationException(trans('posterrorcodes.0305'));

        if( is_null($postId) || is_null($this->postRepository->findById($postId)))
            throw new PostValidationException(trans('posterrorcodes.0306'));

        $markers = $this->postRepository->GetPostMarker($userId,$postId);
       if(!is_null($markers) && count($markers) > 0)
            throw new PostValidationException(trans('posterrorcodes.0304'));

        $id = $this->postRepository->SavePostMarker($postMarker,$userId,$postId);

        Logger::endMethod($method);
        return $id;
    }

    public function SavePostComplaint(Entities\Post\PostComplaint $postComplaint,$userId, $postId)
    {
        $method = 'SavePostComplaint';
        Logger::startMethod($method);

        if( is_null($userId) || !$this->authHandler->UserExists($userId))
            throw new PostValidationException(trans('posterrorcodes.0305'));

        if( is_null($postId) || is_null($this->postRepository->findById($postId)))
            throw new PostValidationException(trans('posterrorcodes.0306'));
        $id = $this->postRepository->SavePostComplaint($postComplaint,$userId,$postId);

        Logger::endMethod($method);
        return $id;

    }


    /**
     * @param UploadedFile $file
     *
     * @return string
     * @throws \Exception
     */
    public function StorePhoto(UploadedFile $file)
    {
        $method = 'StorePhoto';

        Logger::startMethod($method);

        try {
            if ($file->isValid()) {
                $originalName = $file->getClientOriginalName();
                $extension    = $file->getClientOriginalExtension();
                $filename     = substr($originalName, 0, strlen($originalName) - strlen($extension) - 1);
                $filename     = $this->sanitize($filename);
                $filename     = $this->createUniqueFilename($filename, $extension);

                $img = Image::make($file);
                $img->resize(800,null,function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $img->save(env('PHOTOS_PATH'). $filename);
                //$file->move(env('PHOTOS_PATH'), $filename);
                Logger::endMethod($method);

                return env('PHOTOS_PATH') . $filename;

            } else {
                throw new PostValidationException($file->getErrorMessage());
            }

        }catch (\Exception $ex)
        {
            Logger::logError($method,trans('posterrorcodes.0307').'Error'.$ex->getMessage().'STACKTRACE:'.$ex->getTraceAsString());
            throw $ex;
        }

    }

    public function DeletePhoto($photo)
    {
        $method = 'DeletePhoto';

        Logger::startMethod($method);

        try {

            if(is_null($photo) || is_null($photo['path']) || is_null($photo['id']))
                throw new \Exception(trans('posterrorcodes.0310').'Error');

            else {

                $this->postRepository->DeletePhoto($photo['id']);
              return  $this->DeletePhysicalPhoto($photo['path']);
            }


        }
        catch (\Exception $ex)
        {
            Logger::logError($method, $ex->getMessage().'Error'.$ex->getMessage().'STACKTRACE:'.$ex->getTraceAsString());
            throw $ex;
        }

    }

    public function GetPhotosByMapItemId($mapItemId)
    {
        Logger::startMethod('GetPhotosByMapItemId');
        return $this->postRepository->GetPhotosByMapItemId($mapItemId);
    }

    public function DeletePhysicalPhoto($filePath)
    {
        $method = 'DeletePhysicalPhoto';

        Logger::startMethod($method);

        try {

            $file = File::get($filePath);

            if(is_null($file))
            {
                throw new \Exception(trans('posterrorcodes.0308').'Error');
            }
            else {
                File::delete($filePath);
            }

            return true;

        }
        catch (\Exception $ex)
        {
            Logger::logError($method, $ex->getMessage().'Error'.$ex->getMessage().'STACKTRACE:'.$ex->getTraceAsString());
            return false;
        }
    }

    private function createUniqueFilename( $filename, $extension )
    {
        $dir = env('PHOTOS_PATH');
        $newFileName = $filename;
        $image_path = $dir . $newFileName . '.' . $extension;
        while( File::exists( $image_path ))
        {
            $imageToken = substr(sha1(mt_rand()), 0, 5);
            $newFileName = $filename.'_'.$imageToken.'.'.$extension;
            $image_path = $dir . $newFileName;
        }

        return $newFileName . '.' . $extension;
    }

    private function sanitize($string, $force_lowercase = true, $anal = false)
    {
        $strip = ["~", "`", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "_", "=", "+", "[", "{", "]",
            "}", "\\", "|", ";", ":", "\"", "'", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;", "&#8212;",
            "â€”", "â€“", ",", "<", ".", ">", "/", "?"];
        $clean = trim(str_replace($strip, "", strip_tags($string)));
        $clean = preg_replace('/\s+/', "-", $clean);
        $clean = ($anal) ? preg_replace("/[^a-zA-Z0-9]/", "", $clean) : $clean ;

        return ($force_lowercase) ?
            (function_exists('mb_strtolower')) ?
                mb_strtolower($clean, 'UTF-8') :
                strtolower($clean) :
            $clean;

    }

}