<?php

namespace Jakeydevs\Analytics;

use Jakeydevs\Analytics\View\Components\Bounce;
use Jakeydevs\Analytics\View\Components\Uniques;
use Jakeydevs\Analytics\View\Components\Views;
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

        //-- Load resources
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'analytics');
        $this->loadViewComponentsAs('analytics', [
            \Jakeydevs\Analytics\View\Components\Views::class,
            \Jakeydevs\Analytics\View\Components\Uniques::class,
            \Jakeydevs\Analytics\View\Components\Bounce::class,
            \Jakeydevs\Analytics\View\Components\Duration::class,
        ]);

        //-- Create our middleware
        $router = $this->app->make(\Illuminate\Routing\Router::class);
        $router->aliasMiddleware(
            'pageview',
            \Jakeydevs\Analytics\Http\Middleware\RecordPageview::class
        );

        //-- Console commands
        $this->commands([
            \Jakeydevs\Analytics\Console\ParsePageview::class,
            \Jakeydevs\Analytics\Console\CreateDummyData::class,
        ]);

        //-- What can the user edit?
        if ($this->app->runningInConsole()) {
            //-- Config
            $this->publishes([
                __DIR__ . '/../config/analytics.php' => config_path('analytics.php'),
            ], 'config');
            //-- TODO: Views
        }
    }
}
