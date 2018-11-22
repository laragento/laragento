<?php

namespace Laragento\Admin\Exceptions;


use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Container\Container;

class AdminHandler extends \Illuminate\Foundation\Exceptions\Handler
{

    /**
     * Convert an authentication exception into a response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)

    {
        $guard = array_get($exception->guards(), 0);
        switch ($guard) {
            case 'admins':
                $login = 'admin.login.show';
                break;
            default:
                $login = 'login';
                break;
        }
        return $request->expectsJson()
            ? response()->json(['message' => $exception->getMessage()], 401)
            : redirect()->guest(route($login));
    }
}
