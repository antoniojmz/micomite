<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

// Facades
use Config;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(){
        //
        view()->share('app_name_project',   Config::get('brand.name_project'));
        view()->share('app_des_project',    Config::get('brand.des_project'));
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
