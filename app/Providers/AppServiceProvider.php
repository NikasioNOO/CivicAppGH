<?php

namespace CivicApp\Providers;

use Illuminate\Support\ServiceProvider;
use CivicApp\DAL\Auth\IUserRepository;

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
        $this->app->bind('\DAL\Auth\IUserRepository','\DAL\Auth\IUserRepository');

    }
}
