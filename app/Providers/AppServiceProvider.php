<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Dusk\DuskServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        View::composer('clients.index', 'App\Http\ViewComposers\ClientsComposer');
        View::composer('clients.edit', 'App\Http\ViewComposers\ClientsComposer');
        View::composer('clients.show', 'App\Http\ViewComposers\ClientsComposer');
        View::composer('clients.create', 'App\Http\ViewComposers\ClientsComposer');
        View::composer('actions.index', 'App\Http\ViewComposers\ActionsComposer');
        View::composer('actions.edit', 'App\Http\ViewComposers\ActionsComposer');
        View::composer('actions.create', 'App\Http\ViewComposers\ActionsComposer');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment('local', 'testing')) {
            $this->app->register(DuskServiceProvider::class);
            $this->app->register('Appzcoder\CrudGenerator\CrudGeneratorServiceProvider');
        }
    }
}
