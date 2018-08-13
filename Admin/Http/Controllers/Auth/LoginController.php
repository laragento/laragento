<?php

namespace Laragento\Admin\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laragento\Core\Http\Controllers\Auth\LoginController as BaseLoginController;

class LoginController extends BaseLoginController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('guest:admins', ['except' => ['logout']]);
        $this->redirectTo = config('admin.afterlogin_redirect');
    }


    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo;
    protected $guard = 'admins';


    /**
     * Show the admin's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showForm()
    {
        return view('admin::auth.login');
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request $request
     * @return void
     */
    protected function validateLogin(Request $request)
    {

        $this->validate($request,
            [
                $this->username() => 'required|email',
                'password' => 'required|string',
            ]
        );


    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  mixed $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        return redirect(config('admin.afterlogin_redirect'));
    }

    /**
     *
     * @return property guard use for login
     *
     */
    public function guard()
    {
        return Auth::guard('admins');
    }

    /**
     * Get the post register / login redirect path.
     *
     * @return string
     */
    public function redirectPath()
    {
        return config('admin.afterlogin_redirect');
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $sessionKey = $this->guard()->getName();

        $this->guard()->logout();

        $request->session()->forget($sessionKey);

        return redirect($this->redirectPath() . '/login');
    }

}
