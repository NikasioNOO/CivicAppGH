<?php
/**
 * Created by PhpStorm.
 * User: Nico
 * Date: 08/09/2015
 * Time: 01:01 AM
 */

namespace CivicApp\DAL\Auth;

use CivicApp\DAL\Repository\Repository;
use CivicApp\Entities\Auth as AuthEntities;
use CivicApp\Models\Auth as AuthModels;
use CivicApp\Utilities\Mapper ;
use CivicApp\Entities\Base\BaseEntity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use CivicApp\Utilities\Logger;


class SocialUserRepository extends Repository implements ISocialUserRepository
{

    protected $isSocialUser = false ;
    /**
     * Specify Model class name
     *
     * @return \Illuminate\Database\Eloquent\Model
     */

     function model()
    {
        return  AuthModels\Social_User::class;

    }

    protected function entity()
    {
        return AuthEntities\SocialUser::class;
    }


    function CreateOrUpdateUser(AuthEntities\SocialUser $user)
    {
        $methodName = 'CreateOrUpdateUser';
        Logger::startMethod($methodName);
        $dbUser = $this->findBy('email',$user->email);
        if(!$dbUser)
        {
            $dbUser = $this->create($user);

        }
        else
        {
           $dbUser  = $this->CheckIfUserNeedUpdate($user,$dbUser);

        }

        Logger::endMethod($methodName);
        return $dbUser->id;

    }

    private function  CheckIfUserNeedUpdate(AuthEntities\SocialUser $userUpdate, AuthModels\Social_User $dbUser)
    {
        $methodName = 'CheckIfUserNeedUpdate';
        Logger::startMethod($methodName);

        $modUser = $this->mapper->map($this->entity(), $this->model(), $userUpdate);

        $arrModUser = $modUser->toArray();
        $arrDbUser = $dbUser->toArray();

        if(!empty(array_diff($arrModUser,$arrDbUser)))
        {
            $dbUser->username = $modUser->username;
            $dbUser->first_name = $modUser->first_name;
            $dbUser->last_name = $modUser->last_name;
            $dbUser->avatar = $modUser->avatar;
            $dbUser->provider = $modUser->provider;
            $dbUser->provider_id = $modUser->provider_id;
            $dbUser->save();

        }

        Logger::endMethod($methodName);
        return $dbUser;



    }


}