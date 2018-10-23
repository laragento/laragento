<?php


namespace Laragento\Admin\Repositories;


use Laragento\Admin\Models\AdminUser;

class AdminUserRepository
{
    public function first($id)
    {
        AdminUser::whereHas('roles', function ($query) {
            $query->where('name', 'lg_admin');
        })->where('user_id', $id)->get();

    }

    public function all()
    {
        return AdminUser::all();
    }
}