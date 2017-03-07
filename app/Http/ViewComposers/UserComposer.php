<?php
/**
 * Created by PhpStorm.
 * User: Nico
 * Date: 12/10/2015
 * Time: 09:20 PM
 */

namespace CivicApp\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use CivicApp\Utilities;
use CivicApp\DAL\Auth;

class UserComposer {


    private  $userRepository;

    public function __construct( Auth\IUserRepository $userRepo )
    {
        $this->userRepository = $userRepo;
    }

    /**
     * @param View $view
     */
    public function compose(View $view)
    {

        $roles=  $this->userRepository->getRoles();

        $ddlRoles = [];
        foreach( $roles as $role) {
            $ddlRoles[$role->id] = $role->role_name;
        }
        //$ddlRoles = ['1'=>'Administrator','2'=>'User']  ;

        $view->with('ddlRoles',$ddlRoles);
    }

}