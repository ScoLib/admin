<?php

use Illuminate\Database\Seeder;
use Sco\Admin\Models\Role;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $userModelName = config('auth.providers.users.model');
        $user          = new $userModelName();
        if ($user->count() == 0) {
            $role           = Role::where('name', 'admin')->firstOrFail();
            $user->name     = 'admin';
            $user->email    = 'admin@admin.com';
            $user->password = '123456';
            $user->save();
            $user->attachRole($role);
        }
    }
}
