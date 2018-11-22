<?php

namespace Laragento\Core\Http\Middleware;

use Closure;
use Illuminate\Foundation\Application;
use Laragento\Store\Models\Store;
use Laragento\Store\Repositories\StoreRepositoryInterface;


class ApiStoreIdMiddleware
{
    protected $app;
    protected $store;

    /**
     * ApiStoreIdMiddleware constructor.
     */
    public function __construct(Application $app, StoreRepositoryInterface $storeRepository)
    {
        $this->app = $app;
        $this->store = $storeRepository;
    }

    public function handle($request, Closure $next)
    {
        if (!$request->header('X-Store-Code')) {
            $store = $this->store->first(0);
        } else {
            $store = $this->store->first($request->header('X-Store-Code'));
            if (!$store) {
                $store = $this->store->first(0);
            };

        }
        $storeId = $store['store_id'];
        $request->attributes->set('store_id', $storeId);

        $response = $next($request);
        $allowedOrigins = [
            
        ];

        if (! $response->headers->has('Access-Control-Allow-Origin') && in_array($request->header('Origin'),$allowedOrigins)) {
            $response->headers->set('Access-Control-Allow-Origin', $request->header('Origin'));
        }


        //ToDo to be removed, for ResponseTesting only
        $response->headers->set('X-Store-Code', 'handled in Middleware');
        $response->headers->set('X-Store-ID', $storeId);



        return $response;
    }
}