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

    public function GetAllPostByObra($obraId)
    {
        $method = 'GetAllPostByObra';
        try{
            Logger::startMethod($method);


            if(is_null($this->obraHandler->GetObra($obraId)))
                throw new PostValidationException(trans('posterrorcodes.0301',['id'=>$obraId]),300);

            Logger::endMethod($method);

            return $this->postRepository->GetPostsByObraId($obraId);

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
        $this->ValidatePost($post);
        $id = $this->postRepository->SavePost($post);
        Logger::endMethod($method);
        return $id;


    }

    private function ValidatePost(Entities\Post\Post $post)
    {
        $method = 'ValidatePost';
        Logger::startMethod($method);

        if(is_null($post))
            throw new PostValidationException(trans('posterrorcodes.0300'));

        if(empty(trim($post->comment)))
            throw new PostValidationException(trans('posterrorcodes.0302'));

        if(is_null($post->mapItem) || is_null($this->obraHandler->GetObra($post->mapItem->id)))
            throw new PostValidationException(trans('posterrorcodes.0301',['id'=>$post->mapItem->id]),300);

        if(is_null($post->status) || is_null($this->catalogRepository->GetStatus($post->status->id)))
            throw new PostValidationException(trans('posterrorcodes.0303',['catalog'=>'El Estado']));

        if(!is_null($post->postType) && is_null($this->catalogRepository->GetPostType($post->postType->id)))
            throw new PostValidationException(trans('posterrorcodes.0303',['catalog'=>'El Tipo de Post']));

        if(is_null($post->user) || !$this->authHandler->UserExists($post->user->id))
            throw new PostValidationException(trans('posterrorcodes.0303',['catalog'=>'El usuario']));

        Logger::endMethod($method);

    }

    public function SavePostMarker(Entities\Post\PostMarker $postMarker, $userId, $postId)
    {
        $method = 'SavePostMarker';

        Logger::startMethod($method);

        if( is_null($userId) || !$this->authHandler->UserExists($userId))
            throw new PostValidationException(trans('posterrorcodes.0305'));

        if( is_null($postId) || is_null($this->postRepository->findById($postId)))
            throw new PostValidationException(trans('posterrorcodes.0306'));

      /*  if(!is_null($this->postRepository->GetPostMarker($userId,$postId)))
            throw new PostValidationException(trans('posterrorcodes.0304'));*/

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

}