<?php

use Illuminate\Database\Seeder;
use Sco\Admin\Models\Role;

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        $admin = new Role();
        $admin->name = 'admin';
        $admin->display_name = '超级管理员';
        $admin->save();

        $test = new Role();
        $test->name = 'test';
        $test->display_name = '测试组';
        $test->save();

    }
}
