

|--------|----------|-------------------------------|-----------------------|---------------------------------------------------------------|----------------------------------------------|
| Domain | Method   | URI                           | Name                  | Action                                                        | Middleware                                   |
|--------|----------|-------------------------------|-----------------------|---------------------------------------------------------------|----------------------------------------------|
|        | GET|HEAD | _debugbar/assets/javascript   | debugbar.assets.js    | Barryvdh\Debugbar\Controllers\AssetController@js              | Barryvdh\Debugbar\Middleware\DebugbarEnabled |
|        | GET|HEAD | _debugbar/assets/stylesheets  | debugbar.assets.css   | Barryvdh\Debugbar\Controllers\AssetController@css             | Barryvdh\Debugbar\Middleware\DebugbarEnabled |
|        | DELETE   | _debugbar/cache/{key}/{tags?} | debugbar.cache.delete | Barryvdh\Debugbar\Controllers\CacheController@delete          | Barryvdh\Debugbar\Middleware\DebugbarEnabled |
|        | GET|HEAD | _debugbar/clockwork/{id}      | debugbar.clockwork    | Barryvdh\Debugbar\Controllers\OpenHandlerController@clockwork | Barryvdh\Debugbar\Middleware\DebugbarEnabled |
|        | GET|HEAD | _debugbar/open                | debugbar.openhandler  | Barryvdh\Debugbar\Controllers\OpenHandlerController@handle    | Barryvdh\Debugbar\Middleware\DebugbarEnabled |
|--------|----------|-------------------------------|-----------------------|---------------------------------------------------------------|----------------------------------------------|
