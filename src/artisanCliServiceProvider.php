<?php

namespace artisan_cli\gui;
use Illuminate\Support\ServiceProvider;

class artisanCliServiceProvider extends  ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

    }
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadViewsFrom(__DIR__.'/resources/views', 'ArtisanCLI');
        $this->publishVendors();

    }
    protected function publishVendors()
    {
        $this->publishes([
            __DIR__.'/resources/views' => resource_path('views/artisanCli')
        ]);
    }
}
