<?php

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $this->storePermission('view_admin', '访问后台');
        $this->storePermission('manage_log', '管理操作日志');

        $this->storePermission('view_user', '查看用户');
        $this->storePermission('create_user', '创建用户');
        $this->storePermission('edit_user', '编辑用户');
        $this->storePermission('delete_user', '删除用户');

        $this->storePermission('view_role', '查看角色');
        $this->storePermission('create_role', '创建角色');
        $this->storePermission('edit_role', '编辑角色');
        $this->storePermission('delete_role', '删除角色');

        $this->storePermission('view_permission', '查看权限');
        $this->storePermission('create_permission', '创建权限');
        $this->storePermission('edit_permission', '编辑权限');
        $this->storePermission('delete_permission', '删除权限');

        $this->storePermission('admin.system.menu', '菜单');
    }

    private function storePermission($name, $displayName, $description = '')
    {
        $permissionModelName = config('admin.permission');
        $permission          = new $permissionModelName();

        $permission->display_name = $displayName;
        $permission->name         = $name;
        $permission->description  = $description;
        $permission->save();

        return $permission;
    }
}
