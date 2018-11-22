<?php

namespace Laragento\Admin\Database\Seeders;

use Illuminate\Database\Seeder;
use Laragento\Admin\Models\AdminRole;
use Laragento\Admin\Models\AdminUser;

class AdminUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $user = factory(AdminUser::class)->create();

        $role = AdminRole::whereName('lg_root')->get();

        $user->roles()->attach($role);

    }
}
