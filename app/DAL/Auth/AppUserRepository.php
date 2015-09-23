<?php
/**
 * Created by PhpStorm.
 * User: Nico
 * Date: 08/09/2015
 * Time: 01:01 AM
 */

namespace CivicApp\DAL\Auth;

use CivicApp\DAL\Repository\Repository;
use CivicApp\Entities\Auth;
use CivicApp\Models\Auth\Role;


class AppUserRepository extends Repository  {


    /**
     * Specify Model class name
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    function model()
    {
        return 'CivicApp\Models\Auth\App_User';
    }

    protected function entity()
    {
        return 'CivicApp\Entities\Auth\AppUser';
    }

    /**
     * @param \CivicApp\Entities\Auth\AppUser $entity
     */
    function mapToModel($entity)
    {
        $newModel = $this->basicMapToModel($entity);

        foreach($entity->roles as $role)
        {
            $newRole = new Role();



        }

    }

    function create( $user)
    {



    }

    public  function  setRolToUser()
    {}

    function mapToEntity($dataModel)
    {
        // TODO: Implement mapToEntity() method.
    }
}