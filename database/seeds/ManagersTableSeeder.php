<?php

use Illuminate\Database\Seeder;
use Sco\Admin\Models\Manager;
use Sco\Admin\Models\Role;

class ManagersTableSeeder extends Seeder
{

    public function run()
    {
        $role = Role::where('name', 'admin')->firstOrFail();
        $manager = new Manager();
        $manager->name = 'admin';
        $manager->email = 'admin@admin.com';
        $manager->password = '123456';
        $manager->save();
        $manager->attachRole($role);
    }
}
