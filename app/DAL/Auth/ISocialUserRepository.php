<?php
/**
 * Created by PhpStorm.
 * User: Nico
 * Date: 03/03/2016
 * Time: 01:10 AM
 */

namespace CivicApp\DAL\Auth;

use CivicApp\Entities\Auth as AuthEntities;
use CivicApp\DAL\Repository;

interface ISocialUserRepository extends Repository\IRepository, Repository\ICriteria
{
    function CreateOrUpdateUser(AuthEntities\SocialUser $user);

}