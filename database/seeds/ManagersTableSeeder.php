<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ManagersTableSeeder extends Seeder
{
    private $managerModel;

    public function __construct()
    {
        $guard              = config('admin.guard');
        $provider           = config("auth.guards.{$guard}.provider");
        $managerModelName   = config("auth.providers.{$provider}.model");
        $this->managerModel = new $managerModelName();
    }

    public function run()
    {
        $managerTable = $this->managerModel->getTable();
        if ($managerTable != 'users') {
            DB::table($managerTable)->insert([
                'id'         => 1,
                'name'       => 'admin',
                'email'      => 'admin@admin.com',
                'password'   => bcrypt('123456'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
