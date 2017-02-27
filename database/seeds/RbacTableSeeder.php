<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class RbacTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table(config('admin.user_table'))->insertGetId([
            'name'       => 'admin',
            'email'      => 'admin@admin.com',
            'password'   => bcrypt('123456'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $database = file_get_contents(__DIR__ . '/' . 'rbac.sql');
        $prefix   = env('DB_PREFIX', '');
        $database = str_replace('sco_', $prefix, $database);

        DB::connection()->getPdo()->exec($database);
    }
}
