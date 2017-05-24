<?php

Route::group([
    'prefix'     => 'admin',
    'middleware' => 'web',
    'namespace'  => 'Sco\Admin\Http\Controllers',
    'as'         => 'admin.',
], function () {

    // 登录
    Route::group(['namespace' => 'Auth'], function () {
        //登录页
        Route::get('login', 'LoginController@showLoginForm')
            ->name('login')
            ->middleware('admin.phptojs');

        //登录提交
        Route::post('login', 'LoginController@login')
            ->name('login.submit');
        //退出
        Route::get('logout', 'LoginController@logout')
            ->name('logout');
    });

    Route::group(['middleware' => 'auth.admin'], function () {
        $spaRoutes = [
            // 控制台
            'dashboard'         => '/',
            // 403
            '403'               => '403',
            // 操作日志
            'system.log'        => 'system/log',
            // 菜单管理
            'system.menu'       => 'system/menu',
            // 管理员
            'users.user'        => 'users/user',
            // 角色管理
            'users.role'        => 'users/role',
            // 创建角色
            'users.role.create' => 'users/role/create',
            // 编辑角色
            'users.role.edit'   => 'users/role/{id}/edit',

        ];

        foreach ($spaRoutes as $name => $route) {
            Route::get($route, function () {
                return view('admin::app');
            })->name($name)
                ->middleware(['admin.permissions', 'admin.phptojs']);
        }

        Route::get('menu', function () {
            $menus = request()->attributes->get('admin.menu');
            return response()->json($menus);
        })->name('menu')
            ->middleware('admin.menu');

        Route::get('permissions', function () {
            $permissions = request()->attributes->get('admin.permissions');
            return response()->json($permissions);
        })->name('permissions')
            ->middleware('admin.permissions');
    });

    Route::group(['middleware' => 'auth.admin'], function () {
        // 系统管理
        Route::group([
            'as'        => 'system.',
            'namespace' => 'System',
            'prefix'    => 'system',
        ], function () {
            // 后台菜单
            Route::group(['as' => 'menu.', 'prefix' => 'menu'], function () {
                // 菜单列表数据
                Route::get('list', 'MenuController@getList')
                    ->name('list');

                // 保存菜单
                Route::post('save', 'MenuController@save')
                    ->name('save');

                // 删除菜单
                Route::delete('{id}', 'MenuController@delete')
                    ->name('delete')
                    ->where('id', '[0-9]+');

                // 批量删除菜单
                Route::post('batch/delete', 'MenuController@batchDelete')
                    ->name('batch.delete');
            });

            // 操作日志
            Route::get('log/list', 'ActionLogController@getList')
                ->name('log.list');

        });

        // 管理组
        Route::group([
            'as'        => 'users.',
            'prefix'    => 'users',
            'namespace' => 'Users',
        ], function () {
            // 管理员
            Route::group(['as' => 'user.', 'prefix' => 'user'], function () {
                // 管理员列表数据
                Route::get('list', 'UserController@getList')
                    ->name('list');

                Route::post('save', 'UserController@save')
                    ->name('save');

                Route::post('save/role', 'UserController@saveRole')
                    ->name('save.role');

                Route::delete('{id}', 'UserController@delete')
                    ->name('delete')
                    ->where('id', '[0-9]+');

                Route::get('role/all', 'UserController@getAllRole')
                    ->name('role.all');
            });

            // 角色管理
            Route::group(['as' => 'role.', 'prefix' => 'role'], function () {
                Route::post('save', 'RoleController@save')
                    ->name('save');

                Route::get('{id}', 'RoleController@get')
                    ->name('get')
                    ->where('id', '[0-9]+');

                Route::delete('{id}', 'RoleController@delete')
                    ->name('delete')
                    ->where('id', '[0-9]+');

                // 角色列表
                Route::get('list', 'RoleController@getList')
                    ->name('list');

                Route::get('perms/list', 'RoleController@getPermissionList')
                    ->name('perms.list');

                Route::post('batch/delete', 'RoleController@batchDelete')
                    ->name('batch.delete');
            });

        });
    });
});
