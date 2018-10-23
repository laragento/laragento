<?php


namespace Laragento\Admin\Helpers;


use Illuminate\Support\Facades\Auth;

class AuthHelper
{
    public function isRoot()
    {
        return (Auth::guard('admins')->user()->hasRole('lg_root'));
    }

    public function isEditor()
    {
        return (Auth::guard('admins')->user()->hasRole('lg_editor'));
    }
}