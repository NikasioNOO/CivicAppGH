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


    function FindUserSpamer($email)
    {

        $method='FindUserSpamer';
        try{
            Logger::startMethod($method);

            $userDB = AuthModels\Social_User::where('email','=',$email)
                ->where('is_spamer','=',1)->first();

            if(!is_null($userDB))
                return $this->mapper->map(AuthModels\Social_User::class, AuthEntities\SocialUser::class,$userDB);
            else
                return null;

        }
        catch(QueryException $ex)
        {
            Logger::logError($method, $ex->getMessage().$ex->getSql());
            throw new RepositoryException(trans('autherrorcodes.0005'));
        }
        catch(\Exception $ex)
        {
            Logger::logError($method, $ex->getMessage());
            throw new RepositoryException(trans('autherrorcodes.0005'));
        }
    }

    function MarkAsSpamer($userId)
    {

        $method='MarkAsSpamer';
        try{
            Logger::startMethod($method);

            $userDB =$this->model->find($userId);

            if(!is_null($userDB)) {
                $userDB->is_spamer = 1;

                $userDB->save();
            }

            Logger::endMethod($method);

        }
        catch(QueryException $ex)
        {
            Logger::logError($method, $ex->getMessage().$ex->getSql());
            throw new RepositoryException(trans('autherrorcodes.0008'));
        }
        catch(\Exception $ex)
        {
            Logger::logError($method, $ex->getMessage());
            throw new RepositoryException(trans('autherrorcodes.0008'));
        }
    }

    function FindSocialUserSpamer(AuthEntities\SocialUser $user)
    {

        $method='FindUserSpamer';
        try{
            Logger::startMethod($method);

            $userDB = AuthModels\Social_User::where('provider_id','=',$user->provider_id)
                ->where('provider','=',$user->provider)
                ->where('is_spamer','=',1)->get();

            if(!is_null($userDB) && $userDB->count() > 0)
                return true;
            else
                return false;
       //     return $this->mapper->map(AuthModels\Social_User::class, AuthEntities\SocialUser::class,$userDB);

        }
        catch(QueryException $ex)
        {
            Logger::logError($method, $ex->getMessage().$ex->getSql());
            throw new RepositoryException(trans('autherrorcodes.0005'));
        }
        catch(\Exception $ex)
        {
            Logger::logError($method, $ex->getMessage());
            throw new RepositoryException(trans('autherrorcodes.0005'));
        }

    }


    function CreateOrUpdateSocialUser(AuthEntities\SocialUser $user)
    {
        $methodName = 'CreateOrUpdateUser';
        try {
            Logger::startMethod($methodName);
            $dbUser = $this->model->where('provider', '=', $user->provider)->where('provider_id', '=',
                    $user->provider_id)->first();
            if ( ! $dbUser) {
                $dbUser = $this->create($user);

            } else {
                $dbUser = $this->CheckIfUserNeedUpdate($user, $dbUser);

            }

            Logger::endMethod($methodName);

            return $dbUser->id;
        }
        catch(QueryException $ex)
        {
            Logger::logError($methodName, $ex->getMessage().$ex->getSql());
            throw new RepositoryException(trans('autherrorcodes.0006'));
        }
        catch(\Exception $ex)
        {
            Logger::logError($methodName, $ex->getMessage());
            throw new RepositoryException(trans('autherrorcodes.0006'));
        }

    }

    public function CreateOwnUser(AuthEntities\SocialUser $user)
    {
        $methodName = 'CreateOwnUser';
        try {
            Logger::startMethod($methodName);

            $dbUser = $this->create($user);

            Logger::endMethod($methodName);

            return $dbUser->id;
        }
        catch(QueryException $ex)
        {
            Logger::logError($methodName, $ex->getMessage().$ex->getSql());
            throw new RepositoryException(trans('autherrorcodes.0007'));
        }
        catch(\Exception $ex)
        {
            Logger::logError($methodName, $ex->getMessage());
            throw new RepositoryException(trans('autherrorcodes.0007'));
        }

    }

    public function SaveUser(AuthEntities\SocialUser $user)
    {
        $methodName = 'CreateOwnUser';
        try {
            Logger::startMethod($methodName);

            $dbUser = $this->find($user->id);
            $dbUserUpdate = $this->mapper->map( AuthEntities\SocialUser::class,AuthModels\Social_User::class,$user);

            $this->UpdatModelAttribute($dbUser,$dbUserUpdate);

            $dbUser->save();

            Logger::endMethod($methodName);

            return $dbUser->id;
        }
        catch(QueryException $ex)
        {
            Logger::logError($methodName, $ex->getMessage().$ex->getSql());
            throw new RepositoryException(trans('autherrorcodes.0007'));
        }
        catch(\Exception $ex)
        {
            Logger::logError($methodName, $ex->getMessage());
            throw new RepositoryException(trans('autherrorcodes.0007'));
        }

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

    public function FindByActivationCode($code)
    {
        $method = 'FindByActivationCode';

        try
        {
            Logger::startMethod($method);
            $user = AuthModels\Social_User::where('activation_code',$code)->where('activated',false)->first();

            Logger::endMethod($method);
            if(!is_null($user))
                return $this->mapper->map(AuthModels\Social_User::class, AuthEntities\SocialUser::class,$user);
            else
                return null;
        }
        catch(QueryException $ex)
        {
            Logger::logError($method, $ex->getMessage().$ex->getSql().'.STACKTRACE:'.$ex->getTraceAsString());
            throw new RepositoryException(trans('autherrorcodes.0010'));
        }
        catch(\Exception $ex)
        {
            Logger::logError($method, $ex->getMessage().'STACKTRACE:'.$ex->getTraceAsString());
            throw new RepositoryException(trans('autherrorcodes.0010'));
        }
    }

    public function ActivateUser($userId)
    {
        $method = 'UpdateUser';

        try
        {
            Logger::startMethod($method);
            $user =  AuthModels\Social_User::find($userId);

            $user->activated = 1;
            $user->activation_code = null;
            $user->save();
            Logger::endMethod($method);
            return true;

        }
        catch(QueryException $ex)
        {
            Logger::logError($method, $ex->getMessage().$ex->getSql().'.STACKTRACE:'.$ex->getTraceAsString());
            throw new RepositoryException(trans('autherrorcodes.0011'));
        }
        catch(\Exception $ex)
        {
            Logger::logError($method, $ex->getMessage().'STACKTRACE:'.$ex->getTraceAsString());
            throw new RepositoryException(trans('autherrorcodes.0011'));
        }
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