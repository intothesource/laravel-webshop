<?php

namespace IntoTheSource\Webshop;

/**
 * @package Webshop
 * @author David Bikanov <dbikanov@intothesource.com>
 */
use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;

class WebshopServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;
    /**
     * Perform post-registration booting of services.
     * 
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(realpath(__DIR__.'/../views'), 'webshop');
        $this->setupRoutes($this->app->router);
        // this  for conig
                $this->publishes([
                        __DIR__.'/config/webshop.php' => config_path('webshop.php'),
                        __DIR__.'/database/migrations' => database_path('migrations'),
                    //  __DIR__.'/database/seeds' => database_path('seeds'),
                        __DIR__.'/models' => app_path(),
                        __DIR__.'/views' => base_path('resources/views/intothesource/webshop'),
                        __DIR__.'/Http/Controllers' => app_path('Http/Controllers/Intothesource/Webshop'),

                ]);
    }
    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function setupRoutes(Router $router)
    {
        $router->group(['namespace' => 'App\Http\Controllers\IntoTheSource\Webshop'], function ($router) {
            require __DIR__.'/Http/routes.php';
        });
    }
    /**
     * Registers the config file during publishing.
     * 
     * @return void 
     */
    public function register()
    {
        $this->registerWebshop();
        config([
                'config/webshop.php',
        ]);
    }
    /**
     * Registers the packages.
     * 
     * @return Webshop app
     */
    private function registerWebshop()
    {
        $this->app->bind('webshop', function ($app) {
            return new Webshop($app);
        });
    }
}
