<?php

namespace CivicApp\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use CivicApp\Utilities\Enums;
use CivicApp\Utilities\Mapper;
use CivicApp\Utilities\IMapper;
use CivicApp\Models;
use CivicApp\Entities;

class MapperProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(IMapper::class,function(){
            $mapper = $this->app->make(Mapper::class);

            $this->CreateRoleMapper($mapper);
            $this->CreateAppUserMapper($mapper);
            $this->CreateSocialUserMapper($mapper);

            return $mapper;
        });
    }

    private function CreateRoleMapper ( IMapper $mapper )
    {
        $mapper->addMap( Entities\Auth\Role::class , Models\Auth\Role::class , Enums\MapperConfig::toModel);
        $mapper->addMap(Models\Auth\Role::class, Entities\Auth\Role::class, Enums\MapperConfig::toEntity);

    }

    private function CreateAppUserMapper( IMapper $mapper)
    {
        $mapper->addMap( Entities\Auth\AppUser::class,Models\Auth\App_User::class, Enums\MapperConfig::toModel );
        $mapper->addCustomMap(Entities\Auth\AppUser::class,Models\Auth\App_User::class,
            function ( Entities\Auth\AppUser $entityUser,  Models\Auth\App_User $modelUser){

                //printf("\nCustom:\n");

                //var_dump($entityUser);

                //var_dump($modelUser);

                $mapper = App::make(IMapper::class);
                foreach($entityUser->roles as $role)
                {
                    //$rolModel = $this->app->make(Models\Auth\Role::class);

                    // var_dump($role);

                    //$rolModel->id = $role->id;
                    //$rolModel->role_name = $role->role_name;

                    $rolModel = $mapper->map(Entities\Auth\Role::class, Models\Auth\Role::class, $role);

                    $modelUser->roles->push($rolModel);
                }

                return $modelUser;

            });

        $mapper->addMap(Models\Auth\App_User::class,Entities\Auth\AppUser::class, Enums\MapperConfig::toEntity );
        $mapper->addCustomMap(Models\Auth\App_User::class, Entities\Auth\AppUser::class,
            function ( Models\Auth\App_User $modelUser, Entities\Auth\AppUser $entityUser){

                //printf("\nCustom:\n");

                //var_dump($entityUser);

                //var_dump($modelUser);

                //foreach($modelUser->roles as $role)
                //{
                ////$rolEntity = $this->app->make(Entities\Auth\Role::class);

                // var_dump($role);

                ////$rolEntity->id = $role->id;
                ////$rolEntity->role_name = $role->role_name;

//                    $rolEntity = $this->map( Models\Auth\Role::class,Entities\Auth\Role::class, $role);

                //                  $entityUser->roles->push($rolEntity);
                //              }

                $entityRoles = $this->map( Models\Auth\Role::class,Entities\Auth\Role::class, $modelUser->roles->all());

                $entityUser->roles->merge($entityRoles);


                return $entityUser;

            });
    }

    private function CreateSocialUserMapper( IMapper $mapper)
    {
        $mapper->addMap( Entities\Auth\SocialUser::class,Models\Auth\Social_User::class, Enums\MapperConfig::toModel );

        $mapper->addMap(Models\Auth\Social_User::class,Entities\Auth\SocialUser::class, Enums\MapperConfig::toEntity );

    }
}
