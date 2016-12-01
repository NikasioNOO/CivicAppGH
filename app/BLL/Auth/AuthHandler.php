<?php
/**
 * Created by PhpStorm.
 * User: Nico
 * Date: 25/09/2015
 * Time: 01:06 AM
 */

namespace CivicApp\BLL\Auth;

use CivicApp\Utilities;
use CivicApp\DAL\Auth;

use CivicApp\Models;
use CivicApp\Entities;

use Illuminate\Database\QueryException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Mockery\CountValidator\Exception;
use CivicApp\Utilities\Logger;
use Mail;

class AuthHandler {

    private $mapper;
    private $userRepository;
    private $socialUserRepository;

    public function __construct(Utilities\IMapper $mapperNew, Auth\IUserRepository $userRepo
                                , Auth\ISocialUserRepository $socialUserRepo)
    {
        $this->mapper = $mapperNew;
        $this->userRepository = $userRepo;
        $this->socialUserRepository = $socialUserRepo;
    }

    public function CreateUser(Entities\Auth\AppUser $user)
    {
        $method = 'CreateUser';
        Logger::startMethod($method);
        $this->validateCreateUser($user);

        $this->userRepository->SaveUser($user);
        Logger::endMethod($method);
    }

    /**
     * @param Entities\Auth\AppUser $user
     * @throws AuthValidateException
     */
    function validateCreateUser(Entities\Auth\AppUser $user)
    {

        $method = 'validateCreateUser';
        Logger::startMethod($method);
        if ($user->roles->count() == 0) {
            throw new AuthValidateException(trans('autherrorcodes.0001'), 10001);
        }

        $rolesIdDB = $this->userRepository->getRolesIDByIdCollectin($user->roles);

        $rolesId = new Collection();

        foreach ($user->roles as $role) {
            $rolesId->push($role->id);
        }

        /** @var Collection $diff */
        $diff = $rolesId->diff($rolesIdDB);

        if ($diff->count()) {
            throw new AuthValidateException(trans('autherrorcodes.0002'), 10002);
        }


        Logger::endMethod($method);


    }
    /**
     *@return Collection
     */
    function getAllRoles()
    {
        Logger::startMethod('getAllRoles');
        return $this->userRepository->getRoles();

    }

    function CreateOrUpdateSocialUser(Entities\Auth\SocialUser $user)
    {
        $method='CreateOrUpdateSocialUser';
        Logger::startMethod($method);

        if(!$this->socialUserRepository->FindSocialUserSpamer($user))
            $user->id = $this->socialUserRepository->CreateOrUpdateSocialUser($user);
        else
            throw new AuthValidateException(trans('autherrorcodes.0009'));

        Logger::endMethod($method);
        return $user;
    }

    function CreateOwnUser(Entities\Auth\SocialUser $user, $fileAvatar)
    {
        $method='CreateOwnUser';
        Logger::startMethod($method);


        if( !is_null($fileAvatar))
        {
            $user->avatar=  Utilities\ImageHelper::StoreImage($fileAvatar, env('AVATARS_PATH'));
        }

        $user->activation_code = $this->getToken();
        $user->activated = 0;
        $user->provider = 'App';
        $user->provider_id= 0;
        $user->id = $this->socialUserRepository->CreateOwnUser($user);

        Mail::send('emails.verify', ['confirmation_code'=>$user->activation_code], function($message) use ($user) {
            //$message->from('activar@civicapp.com.ar','Monitor de Obras del presupuesto participativo');
            $message->to($user->email, $user->username)
                ->subject('Obras del Presupuesto participativo - Activación de cuenta');
        });

        Logger::endMethod($method);
        return $user;
    }

    private function getToken()
    {
        return hash_hmac('sha256', str_random(40), config('app.key'));
    }

    function ConfirmUser($code)
    {
        $method = '';
        Logger::startMethod($method);

        $user = $this->socialUserRepository->FindByActivationCode($code);

        if(!is_null($user))
        {
            $this->socialUserRepository->ActivateUser($user->id);
            Logger::endMethod($method);
            return $user->id;
        }
        else
        {
            throw new AuthValidateException('El código enviado no corresponde a ningun usuario con la posibilidad de ser activado.');
        }


    }


    /**
     * @param $userId
     *
     * @return bool
     */
    function UserExists($userId)
    {
        Logger::startMethod('UserExists');
        return $this->socialUserRepository->UserExists($userId);
    }

    function GetUserLogued()
    {
        Logger::startMethod('UserExists');
        return $this->socialUserRepository->GetUserLogued();
    }

    function MarkAsSpamer($userId)
    {
        Logger::startMethod('MarkAsSpamer');

        $this->socialUserRepository->MarkAsSpamer($userId);


    }


    public function IsPendingActivation($email)
    {
        Logger::startMethod('IsPendingActivation');
        $user = $this->socialUserRepository->findByRetEntity("email",$email);
        if(is_null($user))
            return false;
        else
        {
            if($user->activated == 0)
                return true;
            else
                return false;

        }

    }

    public function  IsUserSpamer($email)
    {
        Logger::startMethod('IsUserSpamer');

        if(is_null($this->socialUserRepository->FindUserSpamer($email)))
            return false;
        else
            return true;


    }


    public function ResendEmailConfirmation($email)
    {
        $user = $this->socialUserRepository->findByRetEntity('email',$email);
        if(is_null($user))
            throw new AuthValidateException('No existe usuario creado con ese email.');
        if($user->activated == 1)
            throw new AuthValidateException('El usuario con el email '.$email.' ya se encuentra activado');

        if(!is_null($this->socialUserRepository->FindUserSpamer($email)))
            throw new AuthValidateException('El usuario está marcado como spamer');


        $user->activation_code = $this->getToken();
        $this->socialUserRepository->SaveUser($user);

        Mail::send('emails.verify', ['confirmation_code'=>$user->activation_code], function($message) use ($user) {
            //$message->from('activar@civicapp.com.ar','Monitor de Obras del presupuesto participativo');
            $message->to($user->email, $user->username)
                ->subject('Obras del Presupuesto participativo - Activación de cuenta');
        });
    }


}