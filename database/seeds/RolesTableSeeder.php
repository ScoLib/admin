<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        $roleModelName = config('admin.role');

        $admin               = new $roleModelName();
        $admin->name         = 'admin';
        $admin->display_name = '超级管理员';
        $admin->save();

        $permissionModelName = config('admin.permission');
        $admin->attachPermissions((new $permissionModelName())->all());

        $test               = new $roleModelName();
        $test->name         = 'test';
        $test->display_name = '测试组';
        $test->save();
    }
}
