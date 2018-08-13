<?php

namespace Laragento\Admin\Database\Seeders;

use Illuminate\Database\Seeder;
use Laragento\Admin\Models\AdminRole;

class AdminRoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            'lg_user',
            'lg_admin',
            'lg_editor',
            'lg_root',
        ];

        foreach ($roles as $role) {
            factory(AdminRole::class)->create(['name' => $role])->id;
        }
    }
}
