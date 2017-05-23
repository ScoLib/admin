<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class RolesTableSeeder extends Seeder
{
    public function run()
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
}
