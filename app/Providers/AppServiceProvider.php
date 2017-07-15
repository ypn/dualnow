<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Entities\NoticesUsers;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    { 
        View::composer('*', 'App\Http\ComposerProvider\NoticeComposer');
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
