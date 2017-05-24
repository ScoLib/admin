<?php

use Illuminate\Database\Seeder;
use Sco\Admin\Models\Role;
use Sco\Admin\Models\Permission;

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        $admin = new Role();
        $admin->name = 'admin';
        $admin->display_name = '超级管理员';
        $admin->save();
        $admin->attachPermissions(Permission::all());

        $test = new Role();
        $test->name = 'test';
        $test->display_name = '测试组';
        $test->save();

    }
}
