<?php

namespace CivicApp\Http\Controllers;

use CivicApp\BLL\Auth\AuthHandler;
use CivicApp\BLL\Post\PostHandler;
use CivicApp\BLL\Post\PostValidationException;
use CivicApp\Entities\Post\Post;
use CivicApp\Utilities\IMapper;
use CivicApp\Utilities\Logger;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use CivicApp\Http\Requests;
use CivicApp\Entities;
use App;

class ObrasSocialController extends Controller
{


    private $postHandler ;
    private $authHandler;
    private $mapper;

    public function __construct (PostHandler $postHandlerParam, AuthHandler $authHandlerParam, IMapper $mapperparam)
    {
        $this->postHandler = $postHandlerParam;
        $this->mapper      = $mapperparam;
        $this->authHandler = $authHandlerParam;
    }

    public  function getIndex()
    {
        return view('ObrasPresupuestoSocial');
    }


    public function postSendPost(Request $request, Post $post)
    {
        $method = 'postSendPost';
        $msg = '';
        $uploadError = false;
        Logger::startMethod($method);

        try{
            if($request->has('comment'))
            {
                $comment = json_decode( $request->comment);
                $post->comment = $comment->comment;
                if(isset($comment->status) && !is_null($comment->status)
                 && $comment->status->id > 0) {
                    $post->status = App::make(Entities\MapItem\Status::class);
                    $post->status->id     = $comment->status->id;
                    $post->status->status = $comment->status->status;
                }
                //$post = $this->mapper->mapArray(Post::class,json_decode( $request->comment));
                $post->user = $this->authHandler->GetUserLogued();

            }
            else
                throw new \Exception('no se ha recibido un comentario válido');

            if($request->has('obraId'))
            {
                $post->mapItem->id = $request->obraId;
            }
            else
                throw new \Exception('no se ha recibido la obra relacionada');

            if(isset($request->photos) && count($request->photos)>0)
            {
                /** @var UploadedFile $photo */
                foreach($request->photos as $photo)
                {
                    $photoEntity = App::make(Entities\Post\Photo::class);
                    try{

                        $photoEntity->path = $this->postHandler->StorePhoto($photo);

                        $post->photos->push($photoEntity);

                    }
                    catch(PostValidationException $ex)
                    {
                        $uploadError = true;
                        $msg = 'Error al subir el archivo ' . $photo->getClientOriginalName(). ' \n';
                        throw $ex;
                    }

                }

            }

            $result = $this->postHandler->SavePost($post);
            $post = $result['post'];
            $post->positiveCount = 0;
            $post->negativeCount = 0;

            Logger::endMethod($method);
            return response()->json([
                'status' => 'Ok',
                'post' => json_encode($post),
                'statusChange' => $result['statusChange']

            ]);

        }
        catch(\Exception $ex)
        {
            Logger::logError($method,$ex->getMessage().'STACKTRACE'.$ex->getTraceAsString());
            return response()->json([
                'status' => 'Error',
                'message' => $uploadError ? $msg : $ex->getMessage()
            ]);

        }






    }



    public function postMarkPost(Request $request,  Entities\Post\PostMarker $postMarker)
    {
        $method = 'postMarkPost';

        Logger::startMethod($method);

        try{
            if($request->has('postId') && $request->has('marker'))
            {

                $postMarker->is_positive = $request->marker == 1 ? true :false;

                $user = $this->authHandler->GetUserLogued();

                $this->postHandler->SavePostMarker($postMarker,$user->id,$request->postId);
            }
            else
                throw new \Exception('no se ha recibido una marca válida');

            Logger::endMethod($method);

            return response()->json([
                'status' => 'Ok'
            ]);

        }
        catch(\Exception $ex)
        {
            Logger::logError($method,$ex->getMessage().'STACKTRACE'.$ex->getTraceAsString());
            return response()->json([
                'status' => 'Error',
                'message' =>  $ex->getMessage()
            ]);

        }


    }

    public function postSendComplaint(Request $request,  Entities\Post\PostComplaint $postComplaint)
    {
        $method = 'postSendComplaint';

        Logger::startMethod($method);

        try{
            if($request->has('postId') )
            {

                $postComplaint->comment = $request->has('comment') ? $request->comment : '';

                $user = $this->authHandler->GetUserLogued();

                $this->postHandler->SavePostComplaint($postComplaint,$user->id,$request->postId);
            }
            else
                throw new \Exception('Ha ocurrido un error al denuciar el post, disculpe las Molestias');

            Logger::endMethod($method);

            return response()->json([
                'status' => 'Ok'
            ]);

        }
        catch(\Exception $ex)
        {
            Logger::logError($method,$ex->getMessage().'STACKTRACE'.$ex->getTraceAsString());
            return response()->json([
                'status' => 'Error',
                'message' =>  $ex->getMessage()
            ]);

        }


    }
}
