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
    private $mapper;

    public function __construct (PostHandler $postHandlerParam, IMapper $mapperparam)
    {
        $this->postHandler = $postHandlerParam;
        $this->mapper = $mapperparam;
    }

    public  function getIndex()
    {
        return view('ObrasPresupuestoSocial');
    }


    public function postSendPost(Request $request, AuthHandler $authHandler, Post $post)
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
                $post->user = $authHandler->GetUserLogued();

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



        Logger::endMethod($method);


    }

}
