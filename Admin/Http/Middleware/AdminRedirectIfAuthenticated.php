<?php

namespace Laragento\Admin\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminRedirectIfAuthenticated
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {

        $adminPaths = ['admin/login', 'admin/password/request', 'admin/password/reset','admin/password/email'];
        if (Auth::guard($guard)->check()) {
            // ToDo Handle Paths with config
            if ($guard == 'admins' && in_array($request->path(), $adminPaths)) {
                return redirect(config('admin.afterlogin_redirect'));
            }
            if (!in_array($request->path(), $adminPaths) && strpos($request->path(),'admin/password/reset') == false ) {
                return redirect(config('core.afterlogin_redirect'));
            }
        }

        return $next($request);
    }
}
