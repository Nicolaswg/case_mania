<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::aliasComponent('shared._card','card');
        Blade::if('admin',function (){
            return auth()->check() && auth()->user()->isAdmin();
        });
        Paginator::useBootstrap();
        Carbon::setLocale(config('app.locale'));
    }
}
