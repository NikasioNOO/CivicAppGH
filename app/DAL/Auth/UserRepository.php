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


class UserRepository extends Repository implements IUserRepository
{

    protected $isSocialUser = false ;
    /**
     * Specify Model class name
     *
     * @return \Illuminate\Database\Eloquent\Model
     */

    function model()
    {
       if($this->isSocialUser)
           return 'CivicApp\Models\Auth\Social_User';
        else
            return 'CivicApp\Models\Auth\App_User';

    }

    protected function entity()
    {
        if($this->isSocialUser)
            return 'CivicApp\Entities\Auth\SocialUser';
        else
            return 'CivicApp\Entities\Auth\AppUser';
    }


    public function SaveUser(AuthEntities\User $user)
    {
        /** @var Model $userModel */
        $userModel = $this->mapper->map($this->entity(),$this->model(),$user);

        $userModel->save();

        if(isset($userModel->roles) && $userModel->roles->count() > 0) {
          //  $rolesIds = $userModel->roles->pluck('id')->all();
          //  $userModel->roles()->attach([$userModel->roles->pluck('id')->all()]);
            $userModel->roles()->sync($userModel->roles->pluck('id')->all());
        }

        return $userModel->id;
    }

    public function setRoltoUser($userId,array $rolesId)
    {
        if($this->isSocialUser)
            throw new IlegalEntityAuthException("Ilegal set rol to Social user");

        $userExist = $this->find($userId);
        $userExist->roles()->attach($rolesId);
    }

    public function createRol( AuthEntities\Role $role)
    {
        $roleModel = $this->mapper->map('CivicApp\Entities\Auth\Role', 'CivicApp\Models\Auth\Role', $role);

        if(count($roleModel->pages))
        {
            $roleModel->pages()->sync([[$roleModel->pages->pluck('id')->all()]]);
        }

        return $roleModel->id;


    }

    /***
     * @return Collection
     */
    public  function getRoles()
    {

        $roles =  AuthModels\Role::all();


        $entityRoles = $this->mapper->map(AuthModels\Role::class, AuthEntities\Role::class, $roles->all());

        return $entityRoles;

    }

    public  function getRolesIDByIdCollectin(Collection $roles)
    {
        $listRoles = [];
        foreach($roles as $role)
        {
            $listRoles[]= $role->id;

        }
         return AuthModels\Role::whereIn('id', $listRoles)->distinct()->lists('id');

    }






}