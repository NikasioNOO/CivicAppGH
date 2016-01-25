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

use Illuminate\Support\Collection;

class AuthHandler {

    private $mapper;
    private $userRepository;

    public function __construct(Utilities\IMapper $mapperNew, Auth\IUserRepository $userRepo )
    {
        $this->mapper = $mapperNew;
        $this->userRepository = $userRepo;
    }

    public function CreateUser(Entities\Auth\AppUser $user)
    {

        $this->validateCreateUser($user);

        $this->userRepository->SaveUser($user);

    }

    /***
     * Validate the User Entity
     * @param Entities\Auth\AppUser $user
     * @return boolean
     */
    function validateCreateUser(Entities\Auth\AppUser $user)
    {

        $

        if($user->roles->count() == 0)
        {
            throw new AuthValidateException(trans('autherrorcodes.0001'),10001);
        }

        $rolesId = $this->userRepository->getRolesIDByIdCollectin($user->roles);

        /** @var Collection $diff */
        $diff = $user->roles->diff($rolesId);

        if($diff->count())
        {
            throw new AuthValidateException(trans('autherrorcodes.0002'),10002);
        }


    }
    /**
     *@return Collection
     */
    function getAllRoles()
    {
        return $this->userRepository->getRoles();

    }





}