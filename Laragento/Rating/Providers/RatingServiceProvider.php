<?php

namespace Laragento\Rating\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\Factory;

class RatingServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->registerFactories();
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        /* Managers */
        $this->app->bind('Laragento\Rating\Managers\RatingManagerInterface',
            'Laragento\Rating\Managers\RatingManager');


        $this->app->bind('Laragento\Rating\Repositories\RatingRepositoryInterface',
            'Laragento\Rating\Repositories\RatingRepository');
        $this->app->bind('Laragento\Rating\Repositories\RatingOptionRepositoryInterface',
            'Laragento\Rating\Repositories\RatingOptionRepository');

        $ratingApi = 'Laragento\Rating\Http\Api\RatingApi';

        $methods = [
            'get' => [
                'v1/rating/votes' => $ratingApi . '@get',   // all visible votes
                'v1/rating/votes/{entity_id}' => $ratingApi . '@getByEntityPkValue',    // all votes of an entity (e.g productId)
                'v1/rating/{rating_id}/options' => $ratingApi . '@options',
                'v1/rating/{rating_id}' => $ratingApi . '@first',
            ],
            'post' => [

            ],
            'delete' => [

            ]
        ];

        foreach ($methods as $method => $routes) {
            foreach ($routes AS $route => $controller) {
                Route::$method($route, $controller);
            }
        }
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            __DIR__.'/../Config/config.php' => config_path('rating.php'),
        ], 'config');
        $this->mergeConfigFrom(
            __DIR__.'/../Config/config.php', 'rating'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/rating');

        $sourcePath = __DIR__.'/../src/views';

        $this->publishes([
            $sourcePath => $viewPath
        ],'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/rating';
        }, \Config::get('view.paths')), [$sourcePath]), 'rating');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/rating');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'rating');
        } else {
            $this->loadTranslationsFrom(__DIR__ .'/../src/resources/lang', 'rating');
        }
    }

    /**
     * Register an additional directory of factories.
     * @source https://github.com/sebastiaanluca/laravel-resource-flow/blob/develop/src/Modules/ModuleServiceProvider.php#L66
     */
    public function registerFactories()
    {
        if (! app()->environment('production')) {
            app(Factory::class)->load(__DIR__ . '/../database/factories');
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
