<?php

namespace Laragento\Review\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\Factory;

class ReviewServiceProvider extends ServiceProvider
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
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        /* Managers */
        $this->app->bind('Laragento\Review\Managers\ReviewManagerInterface',
            'Laragento\Review\Managers\ReviewManager');

        /* Repositories */
        $this->app->bind('Laragento\Review\Repositories\ReviewRepositoryInterface',
            'Laragento\Review\Repositories\ReviewRepository');

        /* APIs */
        $reviewApi = 'Laragento\Review\Http\Api\ReviewApi';

        /* Routes */
        $methods = [
            'get' => [
                'v1/reviews/{entity_id}' => $reviewApi . '@getByEntity',
                'v1/reviews' => $reviewApi . '@get',
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
            __DIR__.'/../Config/config.php' => config_path('review.php'),
        ], 'config');
        $this->mergeConfigFrom(
            __DIR__.'/../Config/config.php', 'review'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/review');

        $sourcePath = __DIR__.'/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ],'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/review';
        }, \Config::get('view.paths')), [$sourcePath]), 'review');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/review');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'review');
        } else {
            $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'review');
        }
    }

    /**
     * Register an additional directory of factories.
     * @source https://github.com/sebastiaanluca/laravel-resource-flow/blob/develop/src/Modules/ModuleServiceProvider.php#L66
     */
    public function registerFactories()
    {
        if (! app()->environment('production')) {
            app(Factory::class)->load(__DIR__ . '/../Database/Factories');
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
