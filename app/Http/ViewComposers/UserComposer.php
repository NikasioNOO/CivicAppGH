<?php
/**
 * Created by PhpStorm.
 * User: Nico
 * Date: 12/10/2015
 * Time: 09:20 PM
 */

namespace CivicApp\Http\ViewComposers;

use Illuminate\Contracts\View\View;

class UserComposer {


    public function compose(View $view)
    {
        $ddlRoles = ['1'=>'Administrator','2'=>'User']  ;

        $view->with('ddlRoles',$ddlRoles);
    }

}