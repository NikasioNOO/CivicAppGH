<?php

namespace CivicApp\Providers;

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

    }
}
