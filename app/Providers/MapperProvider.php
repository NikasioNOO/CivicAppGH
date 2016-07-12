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

            $this->CreateSimpleCatalogMapper($mapper);
            $this->CreateGeoPointMapper($mapper);
            $this->CreateBarrioMapper($mapper);
            $this->CreateMapItemMapper($mapper);

            $this->CreateMapItemArrayMapper($mapper);

            return $mapper;
        });
    }

    public function CreateSimpleCatalogMapper(IMapper $mapper)
    {
        $mapper->addMap(Entities\MapItem\Category::class, Models\Category::class, Enums\MapperConfig::toModel);
        $mapper->addMap(Models\Category::class, Entities\MapItem\Category::class, Enums\MapperConfig::toEntity);

        $mapper->addMap(Entities\MapItem\Cpc::class, Models\Cpc::class, Enums\MapperConfig::toModel);
        $mapper->addMap(Models\Cpc::class, Entities\MapItem\Cpc::class, Enums\MapperConfig::toEntity);

        $mapper->addMap(Entities\MapItem\MapItemType::class, Models\MapItemType::class, Enums\MapperConfig::toModel);
        $mapper->addMap(Models\MapItemType::class, Entities\MapItem\MapItemType::class, Enums\MapperConfig::toEntity);

        $mapper->addMap(Entities\MapItem\Status::class, Models\Status::class, Enums\MapperConfig::toModel);
        $mapper->addMap(Models\Status::class, Entities\MapItem\Status::class, Enums\MapperConfig::toEntity);

    }

    public function CreateGeoPointMapper(IMapper $mapper)
    {
        $mapper->addMap(Entities\Common\GeoPoint::class, Models\GeoPoint::class, Enums\MapperConfig::toModel);
        $mapper->addMap(Models\GeoPoint::class, Entities\Common\GeoPoint::class, Enums\MapperConfig::toEntity);
    }

    public function callbackMapLocationToModel($entity, $model)
    {
        $mapper = App::make(IMapper::class);
        if(isset($entity->location)) {
            $model->location = $mapper->map(Entities\Common\GeoPoint::class, Models\GeoPoint::class,
                $entity->location);
        }
        return $model;
    }

    public function CreateBarrioMapper(IMapper $mapper)
    {
        $mapper->addMap(Entities\MapItem\Barrio::class, Models\Barrio::class, Enums\MapperConfig::toModel);
        $mapper->addCustomMap(Entities\MapItem\Barrio::class, Models\Barrio::class,
            function(Entities\MapItem\Barrio $entityBarrio,  Models\Barrio $modelBarrio){
                $mapper = App::make(IMapper::class);
                if(!is_null($entityBarrio->location)) {
                    $modelBarrio->location()->associate($mapper->map(Entities\Common\GeoPoint::class, Models\GeoPoint::class,
                        $entityBarrio->location));
                }
                return $modelBarrio;
            });


        $mapper->addMap(Models\Barrio::class, Entities\MapItem\Barrio::class, Enums\MapperConfig::toEntity);
        $mapper->addCustomMap(Models\Barrio::class, Entities\MapItem\Barrio::class,
            function(Models\Barrio $modelBarrio, Entities\MapItem\Barrio $entityBarrio){
                $mapper = App::make(IMapper::class);
                if(isset($modelBarrio->location)) {
                    $entityBarrio->location = $mapper->map( Models\GeoPoint::class, Entities\Common\GeoPoint::class,
                        $modelBarrio->location);
                }
                return $entityBarrio;
            });

    }

    public function CreateMapItemArrayMapper(IMapper $mapper)
    {
        $mapper->addCustomMapArray(Entities\MapItem\MapItem::class,function($array,Entities\MapItem\MapItem $entityMapItem )
        {
            /** @var IMapper $mapper */
            $mapper = App::make(IMapper::class);
            if(isset($array['cpc']) && !is_null($array['cpc']))
            {
                $entityMapItem->cpc = $mapper->mapArray(Entities\MapItem\Cpc::class, $array['cpc']);
            }

            if(isset($array['barrio']) && !is_null($array['barrio']))
            {
                $entityMapItem->barrio = $mapper->mapArray(Entities\MapItem\Barrio::class, $array['barrio']);
            }

            if(isset($array['category']) && !is_null($array['category']))
            {
                $entityMapItem->category = $mapper->mapArray(Entities\MapItem\Category::class, $array['category']);
            }

            if(isset($array['status']) && !is_null($array['status']))
            {
                $entityMapItem->status = $mapper->mapArray(Entities\MapItem\Status::class, $array['status']);
            }

            if(isset($array['mapItemType']) && !is_null($array['mapItemType']))
            {
                $entityMapItem->mapItemType = $mapper->mapArray(Entities\MapItem\MapItemType::class, $array['mapItemType']);
            }

            if(isset($array['location']) && !is_null($array['location']))
            {
                $entityMapItem->location = $mapper->mapArray(Entities\Common\GeoPoint::class, $array['location']);
            }

            return $entityMapItem;

        });

    }

    public function CreateMapItemMapper(IMapper $mapper)
    {
        $mapper->addMap(Entities\MapItem\MapItem::class, Models\MapItem::class, Enums\MapperConfig::toModel);
        $mapper->addCustomMap(Entities\MapItem\MapItem::class, Models\MapItem::class,
            function(Entities\MapItem\MapItem $entityMapItem, Models\MapItem $modelMapItem){
                $mapper = App::make(IMapper::class);
                if(!is_null($entityMapItem->barrio))
                    $modelMapItem->barrio()->associate($mapper->map(Entities\MapItem\Barrio::class, Models\Barrio::class, $entityMapItem->barrio));
                if(!is_null($entityMapItem->cpc))
                    $modelMapItem->cpc()->associate($mapper->map(Entities\MapItem\Cpc::class, Models\Cpc::class, $entityMapItem->cpc));
                if(!is_null($entityMapItem->category))
                    $modelMapItem->category()->associate($mapper->map(Entities\MapItem\Category::class, Models\Category::class, $entityMapItem->category));
                if(!is_null($entityMapItem->status))
                    $modelMapItem->status()->associate($mapper->map(Entities\MapItem\Status::class, Models\Status::class, $entityMapItem->status));
                if(!is_null($entityMapItem->mapItemType))
                    $modelMapItem->mapItemType()->associate($mapper->map(Entities\MapItem\MapItemType::class, Models\MapItemType::class, $entityMapItem->mapItemType));
                if(!is_null($entityMapItem->location))
                    $modelMapItem->location()->associate($mapper->map(Entities\Common\GeoPoint::class, Models\GeoPoint::class, $entityMapItem->location));
                return $modelMapItem;
            });

        $mapper->addMap(Models\MapItem::class, Entities\MapItem\MapItem::class, Enums\MapperConfig::toEntity);
        $mapper->addCustomMap( Models\MapItem::class, Entities\MapItem\MapItem::class,
            function( Models\MapItem $modelMapItem , Entities\MapItem\MapItem $entityMapItem){
                $mapper = App::make(IMapper::class);
                if(isset($modelMapItem->barrio))
                    $entityMapItem->barrio = $mapper->map(Models\Barrio::class, Entities\MapItem\Barrio::class,  $modelMapItem->barrio);
                if(isset($modelMapItem->cpc))
                    $entityMapItem->cpc = $mapper->map(Models\Cpc::class ,Entities\MapItem\Cpc::class,  $modelMapItem->cpc);
                if(isset($modelMapItem->category))
                    $entityMapItem->category = $mapper->map(Models\Category::class,Entities\MapItem\Category::class,  $modelMapItem->category);
                if(isset($modelMapItem->status))
                    $entityMapItem->status = $mapper->map(Models\Status::class, Entities\MapItem\Status::class,  $modelMapItem->status);
                if(isset($modelMapItem->mapItemType))
                    $entityMapItem->mapItemType = $mapper->map(Models\MapItemType::class, Entities\MapItem\MapItemType::class,  $modelMapItem->mapItemType);
                if(isset($modelMapItem->location))
                    $entityMapItem->location = $mapper->map( Models\GeoPoint::class,Entities\Common\GeoPoint::class, $modelMapItem->location);
                return $entityMapItem;
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
