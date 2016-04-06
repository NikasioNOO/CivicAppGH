<?php

namespace CivicApp\Providers;

use CivicApp\DAL\Auth\ISocialUserRepository;
use CivicApp\DAL\Auth\SocialUserRepository;
use Illuminate\Support\ServiceProvider;
use CivicApp\DAL\Auth\IUserRepository;
use CivicApp\DAL\Auth\UserRepository;


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
    }
}
