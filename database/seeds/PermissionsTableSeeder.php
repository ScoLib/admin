<?php

use Illuminate\Database\Seeder;
use Sco\Admin\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $dashboard = $this->insertPerm('admin.dashboard', '控制台', 0, 'fa-dashboard');
        dd($dashboard->roles);
        //$this->insertPerm('admin.menu', '左侧菜单数据', $dashboard->id, '', 0);

    }

    private function insertPerm(
        $name, $displayName, $pid = 0, $icon = '', $isMenu = 1
    ) {
        $permission               = new Permission();
        $permission->pid          = $pid;
        $permission->icon         = $icon;
        $permission->display_name = $displayName;
        $permission->name         = $name;
        $permission->is_menu      = $isMenu;
        $permission->sort         = 1;
        $permission->save();

        return $permission;
    }
}
