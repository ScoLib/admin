<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class RbacTableSeeder extends Seeder
{

    private $managerModel;

    public function __construct()
    {
        $guard              = config('admin.guard');
        $provider           = config("auth.guards.{$guard}.provider");
        $managerModelName   = config("auth.providers.{$provider}.model");
        $this->managerModel = new $managerModelName();
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->insertManager();
        //$this->insertRoles();
        //$this->insertRoleUser();


        $database = file_get_contents(__DIR__ . '/' . 'rbac.sql');
        $prefix   = env('DB_PREFIX', '');
        $database = str_replace('sco_', $prefix, $database);

        DB::connection()->getPdo()->exec($database);
    }

    private function insertManager()
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

    private function insertRoles()
    {
        DB::table('roles')->insert([
            [
                'id'           => 1,
                'name'         => 'admin',
                'display_name' => '超级管理员',
                'description'  => '',
                'created_at'   => Carbon::now(),
                'updated_at'   => Carbon::now(),
            ],
            [
                'id'           => 2,
                'name'         => 'test',
                'display_name' => '测试组',
                'description'  => '',
                'created_at'   => Carbon::now(),
                'updated_at'   => Carbon::now(),
            ],
        ]);
    }

    private function insertRoleUser()
    {
        DB::table('roles')->insert([
            'manager_id' => 1,
            'role_id'    => 1,
        ]);
    }
}
