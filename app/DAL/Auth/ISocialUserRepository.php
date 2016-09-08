<?php
/**
 * Created by PhpStorm.
 * User: Nico
 * Date: 03/03/2016
 * Time: 01:10 AM
 */

namespace CivicApp\DAL\Auth;

use CivicApp\DAL\Repository\RepositoryException;
use CivicApp\Entities\Auth as AuthEntities;
use CivicApp\DAL\Repository;

interface ISocialUserRepository extends Repository\IRepository, Repository\ICriteria
{
    function CreateOrUpdateUser(AuthEntities\SocialUser $user);

    /**
     * Validate if a userId exists
     * @param $userId
     *
     * @return bool
     * @throws RepositoryException
     */
    function UserExists($userId);

}