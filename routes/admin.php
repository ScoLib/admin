<?php

Route::group([
    'prefix'     => 'admin',
    'middleware' => 'web',
    'namespace'  => 'Sco\Admin\Http\Controllers',
], function () {
    //登录页
    Route::get('login',
        'Auth\LoginController@showLoginForm')->name('admin.login');
    //登录提交
    Route::post('login',
        'Auth\LoginController@login')->name('admin.login.submit');
    //退出
    Route::get('logout', 'Auth\LoginController@logout')->name('admin.logout');

    Route::group(['middleware' => 'auth.admin'], function () {
        $spaRoutes = [
            // 控制台
            'admin.dashboard'           => '/',
            // 操作日志
            'admin.system.log'          => 'system/log',
            // 菜单管理
            'admin.system.menu'         => 'system/menu',
            // 管理员
            'admin.manager.user'        => 'manager/user',
            // 角色管理
            'admin.manager.role'        => 'manager/role',
            // 创建角色
            'admin.manager.role.create' => 'manager/role/create',
            // 编辑角色
            'admin.manager.role.edit'   => 'manager/role/{id}/edit',

        ];

        foreach ($spaRoutes as $name => $route) {
            Route::get($route, function () {
                return view('admin::app');
            })->name($name);
        }

        Route::get('menu', function () {
            $menus = request()->get('admin.menu');
            return response()->json($menus);
        })->name('admin.menu')->middleware('admin.menu');

        // 菜单列表数据
        Route::get('system/menu/list', 'System\MenuController@getList')
            ->name('admin.system.menu.list');

        // 保存菜单
        Route::post('system/menu/save', 'System\MenuController@save')
            ->name('admin.system.menu.save');

        // 删除菜单
        Route::delete('system/menu/{id}', 'System\MenuController@delete')
            ->name('admin.system.menu.delete')
            ->where('id', '[0-9]+');

        // 批量删除菜单
        Route::post('system/menu/batch/delete',
            'System\MenuController@batchDelete')
            ->name('admin.system.menu.batch.delete');

        Route::get('system/log/list', 'System\ActionLogController@getList')
            ->name('admin.system.log.list');

        // 管理员列表数据
        Route::get('manager/user/list', 'Manager\UserController@getList')
            ->name('admin.manager.user.list');

        Route::post('manager/user/save', 'Manager\UserController@save')
            ->name('admin.manager.user.save');

        Route::post('manager/user/save/role', 'Manager\UserController@saveRole')
            ->name('admin.manager.user.save.role');

        Route::delete('manager/user/{id}', 'Manager\UserController@delete')
            ->name('admin.manager.user.delete')
            ->where('id', '[0-9]+');


        Route::post('manager/role/save', 'Manager\RoleController@save')
            ->name('admin.manager.role.save');

        Route::get('manager/role/{id}', 'Manager\RoleController@get')
            ->name('admin.manager.role.get')
            ->where('id', '[0-9]+');

        Route::delete('manager/role/{id}', 'Manager\RoleController@delete')
            ->name('admin.manager.role.delete')
            ->where('id', '[0-9]+');

        // 角色列表
        Route::get('manager/role/list', 'Manager\RoleController@getList')
            ->name('admin.manager.role.list');

        Route::get('manager/role/all', 'Manager\RoleController@getAll')
            ->name('admin.manager.role.all');

        Route::get('manager/role/perms/list',
            'Manager\RoleController@getPermissionList')
            ->name('admin.manager.role.perms.list');

        Route::post('manager/role/batch/delete',
            'Manager\RoleController@batchDelete')
            ->name('admin.manager.role.batch.delete');

        //用户管理
        /*Route::group(['prefix' => 'users', 'namespace' => 'Users'], function () {
            //用户列表
            Route::get('user', 'UserController@getIndex')
                ->name('admin.users.user')
                ->middleware('admin.menu');

            // 添加用户
            Route::get('user/add', 'UserController@getAdd')->name('admin.users.user.add');

            // 编辑用户
            Route::get('user/{uid}/edit', 'UserController@getEdit')->name('admin.users.user.edit');

            // 保存添加用户
            Route::post('user/postAdd', 'UserController@postAdd')->name('admin.users.user.postAdd');

            // 保存编辑用户
            Route::post('user/{uid}/edit', 'UserController@postEdit')
                ->name('admin.users.user.postEdit');

            // 删除用户
            Route::get('user/{uid}/delete', 'UserController@getDelete')
                ->name('admin.users.user.delete');

            //角色管理
            Route::get('role', 'RoleController@getIndex')
                ->name('admin.users.role')
                ->middleware('admin.menu');

            // 新增角色
            Route::get('role/add', 'RoleController@getAdd')->name('admin.users.role.add');

            // 保存新增角色
            Route::post('role/postAdd', 'RoleController@postAdd')->name('admin.users.role.postAdd');

            // 编辑角色
            Route::get('role/{id}/edit', 'RoleController@getEdit')->name('admin.users.role.edit');

            // 保存编辑角色
            Route::post('role/{id}/edit', 'RoleController@postEdit')
                ->name('admin.users.role.postEdit');

            // 角色授权
            Route::get('role/{id}/authorize', 'RoleController@getAuthorize')
                ->name('admin.users.role.authorize')
                ->middleware('admin.menu');

            // 删除角色
            Route::get('role/{id}/delete', 'RoleController@getDelete')
                ->name('admin.users.role.delete');

            // 保存角色授权
            Route::post('role/{id}/authorize', 'RoleController@postAuthorize')
                ->name('admin.users.role.postAuthorize');
        });*/
    });
});
