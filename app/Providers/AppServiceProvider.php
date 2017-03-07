<?php

namespace CivicApp\Providers;

use CivicApp\DAL\Auth\ISocialUserRepository;
use CivicApp\DAL\Auth\SocialUserRepository;
use CivicApp\DAL\Post\IPostRepository;
use CivicApp\DAL\Post\PostRepository;
use Illuminate\Support\ServiceProvider;
use CivicApp\DAL\Auth\IUserRepository;
use CivicApp\DAL\Auth\UserRepository;
use CivicApp\DAL\MapItem\IMapItemRepository;
use CivicApp\DAL\MapItem\MapItemRepository;
use CivicApp\DAL\Catalog\ICatalogRepository;
use CivicApp\DAL\Catalog\CatalogRepository;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->bind( IUserRepository::class , UserRepository::class);
        $this->app->bind( ISocialUserRepository::class , SocialUserRepository::class);
        $this->app->bind( IMapItemRepository::class, MapItemRepository::class);
        $this->app->bind( ICatalogRepository::class, CatalogRepository::class);
        $this->app->bind( IPostRepository::class, PostRepository::class);
    }
}
