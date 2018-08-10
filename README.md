Work in Progress.
New Laragento Repo

# Installation
Add following line to your composer.json require block:
`"laragento/laragento": "dev-dev"`

Add following provider to your app.php config: 
`Laragento\LaragentoServiceProvider::class,`


# Create a new Module
Use following Command:<br>
`php artisan module:make MyModule`

In composer.json add psr-4 line "Module" in autoload block:<br>
`"autoload": {
    "classmap": [
        "database/seeds",
        "database/factories"
    ],
    "psr-4": {
        "App\\": "app/",
        "Modules\\": "Modules/"
    }
},`

Add the Provider to your app.php config:<br>
`Modules\MyModuleName\Providers\MyModuleProvider::class,`

The module is ready to use! Great :-)
