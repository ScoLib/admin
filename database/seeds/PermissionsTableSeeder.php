<?php

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $dashboard = $this->insertPerm('admin.dashboard', '控制台', 0, 1,
            'fa-dashboard');
        $this->insertPerm('admin.menu', '左侧菜单数据', $dashboard->id);
        $this->insertPerm('admin.permissions', 'Ajax获取用户权限', $dashboard->id);

        $this->system();
        $this->users();


    }

    private function system()
    {
        $system = $this->insertPerm('#', '系统管理', 0, 1, 'fa-edit');

        $log = $this->insertPerm('admin.system.log', '操作日志', $system->id, 1);
        $this->insertPerm('admin.system.log.list', 'Ajax获取操作日志列表', $log->id);

        $menu = $this->insertPerm('admin.system.menu', '后台菜单', $system->id, 1,
            'fa-link');
        $this->insertPerm('admin.system.menu.list', '菜单列表数据', $menu->id);
        $this->insertPerm('admin.system.menu.store', '创建菜单', $menu->id);
        $this->insertPerm('admin.system.menu.update', '更新菜单', $menu->id);
        $this->insertPerm('admin.system.menu.destroy', '删除菜单', $menu->id);
        $this->insertPerm('admin.system.menu.batch.destroy', '批量删除菜单',
            $menu->id);
    }

    private function users()
    {
        $users = $this->insertPerm('#', '管理组', 0, 1, 'fa-users');

        $user = $this->insertPerm('admin.users.user', '管理员', $users->id, 1,
            'fa-user');
        $this->insertPerm('admin.users.user.list', '管理员列表数据', $user->id);
        $this->insertPerm('admin.users.user.store', '创建管理员', $user->id);
        $this->insertPerm('admin.users.user.update', '更新管理员', $user->id);

        $this->insertPerm('admin.users.user.role.all', 'Ajax获取所有角色数据',
            $user->id, 0, '', '用于创建和编辑');
        $this->insertPerm('admin.users.user.destroy', '删除管理员', $user->id);

        $role = $this->insertPerm('admin.users.role', '角色管理', $users->id, 1,
            'fa-user-plus');
        $this->insertPerm('admin.users.role.list', '角色列表数据', $role->id);
        $this->insertPerm('admin.users.role.store', '创建角色', $role->id);
        $this->insertPerm('admin.users.role.update', '更新角色', $role->id);
        $this->insertPerm('admin.users.role.destroy', '删除角色', $role->id);
        $this->insertPerm('admin.users.role.batch.destroy', '批量删除角色',
            $role->id);
        $this->insertPerm('admin.users.role.create', '创建角色', $role->id);

        $roleEdit = $this->insertPerm('admin.users.role.edit', '编辑角色',
            $role->id);
        $this->insertPerm('admin.users.role.get', '获取角色信息', $roleEdit->id, 0,
            '', '用于编辑角色时获取数据');
        $this->insertPerm('admin.users.role.perms.list', 'ajax获取权限列表',
            $roleEdit->id, 0, '', '用于编辑角色时获取数据');
    }

    private function insertPerm(
        $name, $displayName, $pid, $isMenu = 0, $icon = '', $description = ''
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
}
