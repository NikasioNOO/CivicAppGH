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

        $user->id = $this->socialUserRepository->CreateOwnUser($user);

        Logger::endMethod($method);
        return $user;
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





}