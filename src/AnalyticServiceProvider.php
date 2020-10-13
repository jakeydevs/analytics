<?php

namespace Jakeydevs\Analytics;

use \Illuminate\Support\ServiceProvider;

class AnalyticServiceProvider extends ServiceProvider
{

    /**
     * Register any service providers
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Perform post-reg booting
     *
     * @return void
     */
    public function boot()
    {
        //-- Config
        $this->mergeConfigFrom(__DIR__ . '/../config/analytics.php', 'analytics');

        //-- Load database
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        //-- Create our middleware
        $router = $this->app->make(\Illuminate\Routing\Router::class);
        $router->aliasMiddleware(
            'pageview',
            \Jakeydevs\Analytics\Http\Middleware\RecordPageview::class
        );

        //-- Console commands
        $this->commands([
            \Jakeydevs\Analytics\Console\ParsePageview::class,
        ]);
    }
}
