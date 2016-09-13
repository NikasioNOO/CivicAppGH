<?php
/**
 * Created by PhpStorm.
 * User: Nico
 * Date: 08/09/2015
 * Time: 01:01 AM
 */

namespace CivicApp\DAL\Auth;

use CivicApp\DAL\Repository\Repository;
use CivicApp\DAL\Repository\RepositoryException;
use CivicApp\Entities\Auth as AuthEntities;
use CivicApp\Models\Auth as AuthModels;
use CivicApp\Utilities\Mapper ;
use CivicApp\Entities\Base\BaseEntity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use CivicApp\Utilities\Logger;
use Illuminate\Support\Facades\Auth;


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


    /**
     * Validate if a userId exists
     * @param $userId
     *
     * @return bool
     * @throws RepositoryException
     */
    public function UserExists($userId)
    {
        $method = 'ExistUser';

        try
        {
            Logger::startMethod($method);
            $user = AuthModels\Social_User::find($userId);
            if(!is_null($user))
                return true;
            else
                return false;


        }
        catch(QueryException $ex)
        {
            Logger::logError($method, $ex->getMessage().$ex->getSql().'.STACKTRACE:'.$ex->getTraceAsString());
            throw new RepositoryException(trans('autherrorcodes.0003'));
        }
        catch(\Exception $ex)
        {
            Logger::logError($method, $ex->getMessage().'STACKTRACE:'.$ex->getTraceAsString());
            throw new RepositoryException(trans('autherrorcodes.0003'));
        }

    }



    public function GetUserLogued()
    {
        $method = 'GetUserLogued';

        try{
            Logger::startMethod($method);

            $user = Auth::guard('websocial')->user();

            Logger::endMethod($method);
            return $this->mapper->map(AuthModels\Social_User::class, AuthEntities\SocialUser::class, $user);

        }
        catch(QueryException $ex)
        {
            Logger::logError($method, $ex->getMessage().$ex->getSql().'.STACKTRACE:'.$ex->getTraceAsString());
            throw new RepositoryException(trans('autherrorcodes.0004'));

        }
        catch(\Exception $ex)
        {
            Logger::logError($method, $ex->getMessage().'STACKTRACE:'.$ex->getTraceAsString());
            throw new RepositoryException(trans('autherrorcodes.0003'));
        }

    }


}