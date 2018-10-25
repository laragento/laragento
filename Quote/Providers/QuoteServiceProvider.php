<?php

namespace Laragento\Quote\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;

class QuoteServiceProvider extends ServiceProvider
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
        $this->loadRoutesFrom(__DIR__ . '/../Http/routes.php');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('Laragento\Quote\Repositories\QuoteSessionItemRepositoryInterface',
            'Laragento\Quote\Repositories\QuoteSessionItemRepository');
        $this->app->bind('Laragento\Quote\Repositories\QuoteSessionAddressRepositoryInterface',
            'Laragento\Quote\Repositories\QuoteSessionAddressRepository');
        $this->app->bind('Laragento\Quote\Repositories\QuoteSessionObjectRepositoryInterface',
            'Laragento\Quote\Repositories\QuoteSessionObjectRepository');
        $this->app->bind('Laragento\Quote\Managers\QuoteManagerInterface',
            'Laragento\Quote\Managers\QuoteManager');
        $this->app->bind('Laragento\Quote\Managers\QuoteItemManagerInterface',
            'Laragento\Quote\Managers\QuoteItemManager');
        $this->app->bind('Laragento\SalesRule\DataObjects\RuleInterface',
            'Laragento\SalesRule\DataObjects\Rule');
        $this->app->bind('Laragento\SalesRule\Repositories\SalesRuleRepositoryInterface',
            'Laragento\SalesRule\Repositories\SalesRuleRepository');
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            __DIR__.'/../Config/config.php' => config_path('quote.php'),
        ], 'config');
        $this->mergeConfigFrom(
            __DIR__.'/../Config/config.php', 'quote'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/quote');

        $sourcePath = __DIR__.'/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ],'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/quote';
        }, \Config::get('view.paths')), [$sourcePath]), 'quote');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/quote');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'quote');
        } else {
            $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'quote');
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
