<?php

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        //$this->dashboard();
        //$this->system();
        //$this->users();

        $this->storePermission('view_admin', '访问后台');
        $this->storePermission('manage_log', '管理操作日志');

        $this->storePermission('view_user', '查看用户');
        $this->storePermission('create_user', '创建用户');
        $this->storePermission('update_user', '编辑用户');
        $this->storePermission('delete_user', '删除用户');

        $this->storePermission('view_role', '查看角色');
        $this->storePermission('create_role', '创建角色');
        $this->storePermission('update_role', '编辑角色');
        $this->storePermission('delete_role', '删除角色');

        $this->storePermission('view_permission', '查看权限');
        $this->storePermission('create_permission', '创建权限');
        $this->storePermission('update_permission', '编辑权限');
        $this->storePermission('delete_permission', '删除权限');

        $this->storePermission('admin.system.menu', '菜单');
    }

    private function dashboard()
    {
        $dashboard = $this->insertPerm('admin.dashboard', '控制台', 0, 1,
            'fa-dashboard');
        $this->insertPerm('admin.menu', '左侧菜单数据', $dashboard->id);
        $this->insertPerm('admin.permissions', 'Ajax获取用户权限', $dashboard->id);
    }

    private function system()
    {
        $system = $this->insertPerm('#', '系统管理', 0, 1, 'fa-edit');

        $log = $this->insertPerm('admin.system.log', '操作日志', $system->id, 1);
        $this->insertPerm('admin.system.log.list', 'Ajax获取操作日志列表', $log->id);

        $menu = $this->insertPerm('admin.system.menu', '后台菜单', $system->id, 1,
            'fa-link');
        $this->insertPerm('admin.system.menu.list', '菜单列表数据', $menu->id);
        $this->insertPerm('admin.system.menu.store', '保存菜单', $menu->id);
        $this->insertPerm('admin.system.menu.update', '更新菜单', $menu->id);
        $this->insertPerm('admin.system.menu.destroy', '删除菜单', $menu->id);
        $this->insertPerm('admin.system.menu.batch.destroy', '批量删除菜单',
            $menu->id);
    }

    private function users()
    {
        $users = $this->insertPerm('#', '用户管理', 0, 1, 'fa-users');

        $user = $this->insertPerm('admin.users.user', '用户', $users->id, 1,
            'fa-user');
        $this->insertPerm('admin.users.user.list', 'Ajax获取用户列表数据', $user->id);
        $this->insertPerm('admin.users.user.store', '保存用户', $user->id);

        $updateUser = $this->insertPerm('admin.users.user.update', '更新用户',
            $user->id);
        $this->insertPerm('admin.users.user.role.all', 'Ajax获取所有角色数据',
            $updateUser->id, 0, '', '用于创建和编辑用户');

        $this->insertPerm('admin.users.user.destroy', '删除管理员', $user->id);

        $role = $this->insertPerm('admin.users.role', '角色', $users->id, 1,
            'fa-user-plus');
        $this->insertPerm('admin.users.role.list', '角色列表数据', $role->id);


        $createRole = $this->insertPerm('admin.users.role.create', '创建角色',
            $role->id);
        $this->insertPerm('admin.users.role.store', '保存角色', $createRole->id);

        $roleEdit = $this->insertPerm('admin.users.role.edit', '编辑角色',
            $role->id);
        $this->insertPerm('admin.users.role.get', 'Ajax获取角色信息', $roleEdit->id,
            0,
            '', '用于编辑角色时获取数据');
        $this->insertPerm('admin.users.role.perms.list', 'Ajax获取权限列表',
            $roleEdit->id, 0, '', '用于编辑角色时获取数据');
        $this->insertPerm('admin.users.role.update', '更新角色', $roleEdit->id);

        $this->insertPerm('admin.users.role.destroy', '删除角色', $role->id);
        $this->insertPerm('admin.users.role.batch.destroy', '批量删除角色',
            $role->id);
    }

    private function insertPerm(
        $name,
        $displayName,
        $pid,
        $isMenu = 0,
        $icon = '',
        $description = ''
    ) {
        $permissionModelName = config('admin.permission');
        $permission          = new $permissionModelName();

        $permission->pid          = $pid;
        $permission->icon         = $icon;
        $permission->display_name = $displayName;
        $permission->name         = $name;
        $permission->is_menu      = $isMenu;
        $permission->sort         = 1;
        $permission->description  = $description;
        $permission->save();

        return $permission;
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
