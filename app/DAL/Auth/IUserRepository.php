<?php
/**
 * Created by PhpStorm.
 * User: Nico
 * Date: 08/12/2015
 * Time: 06:38 PM
 */
namespace CivicApp\DAL\Auth;

use CivicApp\Entities\Auth as AuthEntities;
use CivicApp\DAL\Repository;
use Illuminate\Support\Collection;

interface IUserRepository  extends Repository\IRepository, Repository\ICriteria
{
    function SaveUser(AuthEntities\User $user);

    function setRoltoUser($userId, array $rolesId);

    function createRol(AuthEntities\Role $role);

    function getRoles();

    /** @see Devuelve los id de todos los roles envieados por parámetro
     * @param Collection $roles
     */
    function getRolesIDByIdCollectin(Collection $roles);
}