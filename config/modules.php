<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Module Namespace
    |--------------------------------------------------------------------------
    |
    | Default module namespace.
    |
    */

    'namespace' => 'Laragento',

    /*
    |--------------------------------------------------------------------------
    | Module Stubs
    |--------------------------------------------------------------------------
    |
    | Default module stubs.
    |
    */

    'stubs' => [
        'enabled' => false,
        'path' => base_path() . '/vendor/nwidart/laravel-modules/src/Commands/stubs',
        'files' => [
            'start' => 'start.php',
            'routes' => 'Http/routes.php',
            'views/index' => 'Resources/views/index.blade.php',
            'views/master' => 'Resources/views/layouts/master.blade.php',
            'scaffold/config' => 'Config/config.php',
            'composer' => 'composer.json',
        ],
        'replacements' => [
            'start' => ['LOWER_NAME', 'ROUTES_LOCATION'],
            'routes' => ['LOWER_NAME', 'STUDLY_NAME', 'MODULE_NAMESPACE'],
            'json' => ['LOWER_NAME', 'STUDLY_NAME', 'MODULE_NAMESPACE'],
            'views/index' => ['LOWER_NAME'],
            'views/master' => ['STUDLY_NAME'],
            'scaffold/config' => ['STUDLY_NAME'],
            'composer' => [
                'LOWER_NAME',
                'STUDLY_NAME',
                'VENDOR',
                'AUTHOR_NAME',
                'AUTHOR_EMAIL',
                'MODULE_NAMESPACE',
            ],
        ],
        'gitkeep' => false,
    ],
    'paths' => [
        /*
        |--------------------------------------------------------------------------
        | Modules path
        |--------------------------------------------------------------------------
        |
        | This path used for save the generated module. This path also will be added
        | automatically to list of scanned folders.
        |
        */

        'modules' => base_path('Laragento'),
        /*
        |--------------------------------------------------------------------------
        | Modules assets path
        |--------------------------------------------------------------------------
        |
        | Here you may update the modules assets path.
        |
        */

        'assets' => public_path('modules'),
        /*
        |--------------------------------------------------------------------------
        | The migrations path
        |--------------------------------------------------------------------------
        |
        | Where you run 'module:publish-migration' command, where do you publish the
        | the migration files?
        |
        */

        'migration' => base_path('database/migrations'),
        /*
        |--------------------------------------------------------------------------
        | Generator path
        |--------------------------------------------------------------------------
        | Customise the paths where the folders will be generated.
        | Set the generate key to false to not generate that folder
        */
        'generator' => [
            'assets' => ['path' => 'Assets', 'generate' => true],
            'config' => ['path' => 'Config', 'generate' => true],
            'command' => ['path' => 'Console', 'generate' => true],
            'controller' => ['path' => 'Http/Controllers', 'generate' => true],
            'emails' => ['path' => 'Emails', 'generate' => false],
            'event' => ['path' => 'Events', 'generate' => false],
            'factory' => ['path' => 'Database/Factories', 'generate' => true],
            'filter' => ['path' => 'Http/Middleware', 'generate' => true],
            'jobs' => ['path' => 'Jobs', 'generate' => false],
            'lang' => ['path' => 'Resources/lang', 'generate' => true],
            'listener' => ['path' => 'Listeners', 'generate' => false],
            'migration' => ['path' => 'Database/Migrations', 'generate' => true],
            'model' => ['path' => 'Models', 'generate' => true],
            'notifications' => ['path' => 'Notifications', 'generate' => false],
            'policies' => ['path' => 'Policies', 'generate' => false],
            'provider' => ['path' => 'Providers', 'generate' => true],
            'repository' => ['path' => 'Repositories', 'generate' => false],
            'request' => ['path' => 'Http/Requests', 'generate' => true],
            'resource' => ['path' => 'Transformers', 'generate' => false],
            'rules' => ['path' => 'Rules', 'generate' => false],
            'repositories' => ['path' => 'Repositories', 'generate' => false],
            'seeder' => ['path' => 'Database/Seeders', 'generate' => true],
            'test' => ['path' => 'Tests', 'generate' => true],
            'views' => ['path' => 'Resources/views', 'generate' => true],
        ],
    ],
    /*
    |--------------------------------------------------------------------------
    | Scan Path
    |--------------------------------------------------------------------------
    |
    | Here you define which folder will be scanned. By default will scan vendor
    | directory. This is useful if you host the package in packagist website.
    |
    */

    'scan' => [
        'enabled' => false,
        'paths' => [
            base_path('vendor/*/*'),
        ],
    ],
    /*
    |--------------------------------------------------------------------------
    | Composer File Template
    |--------------------------------------------------------------------------
    |
    | Here is the config for composer.json file, generated by this package
    |
    */

    'composer' => [
        'vendor' => 'laragento',
        'author' => [
            'name' => 'Stefan Mettler',
            'email' => 'stefan.mettler92@gmail.com',
        ],
    ],
    /*
    |--------------------------------------------------------------------------
    | Caching
    |--------------------------------------------------------------------------
    |
    | Here is the config for setting up caching feature.
    |
    */
    'cache' => [
        'enabled' => false,
        'key' => 'laravel-modules',
        'lifetime' => 60,
    ],
    /*
    |--------------------------------------------------------------------------
    | Choose what laravel-modules will register as custom namespaces.
    | Setting one to false will require you to register that part
    | in your own Service Provider class.
    |--------------------------------------------------------------------------
    */
    'register' => [
        'translations' => true,
        /**
         * load files on boot or register method
         *
         * Note: boot not compatible with asgardcms
         *
         * @example boot|register
         */
        'files' => 'register',
    ],
];
