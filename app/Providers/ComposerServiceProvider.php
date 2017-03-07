<?php

namespace CivicApp\Providers;



use Illuminate\Contracts\View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        view()->composer('auth.CreateAppUser','CivicApp\Http\ViewComposers\UserComposer');

        view()->composer(['admin.obraspresupuesto','admin.ObrasBulkLoad','home','auth.LoginApp','admin.obraspresupuesto'],'CivicApp\Http\ViewComposers\CatalogComposer');


    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
