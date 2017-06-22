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

    Route::group(['middleware' => ['auth', 'admin.phptojs']], function () {
        $spaRoutes = [
            // 控制台
            'dashboard'         => '/',
            // 403
            '403'               => '403',
            // 操作日志
            //'system.log'        => 'system/log',
            // 菜单管理
            'system.menu'       => 'system/menu',
            // 用户
            //'users'        => 'users',
            // 角色管理
            //'users.role'        => 'users/role',
            // 创建角色
            //'users.role.create' => 'users/role/create',
            // 编辑角色
            //'users.role.edit'   => 'users/role/{id}/edit',

        ];

        foreach ($spaRoutes as $name => $route) {
            Route::get($route, function () {
                return view('admin::app');
            })->name($name);
        }
    });

    Route::group(['middleware' => ['auth']], function () {
        Route::get('menu', function () {
            $menus = Admin::getMenus();
            return response()->json($menus);
        })->name('menu');

        /*Route::get('permissions', function () {
            $permissions = request()->attributes->get('admin.permissions');
            return response()->json($permissions);
        })->name('permissions')
            ->middleware('admin.permissions');*/

        // 操作日志
        /*Route::get('system/log/list', 'System\ActionLogController@getList')
            ->name('system.log.list');*/

        Route::get('check/perm/{name}', function ($name) {
            if (Auth::user()->can($name)) {
                return response()->json(['message' => 'ok']);
            }
            throw new \Illuminate\Auth\Access\AuthorizationException();
        });
    });

    Route::group(['middleware' => ['auth']], function () {

        // 系统管理
        Route::group([
            'as'        => 'system.',
            'namespace' => 'System',
            'prefix'    => 'system',
        ], function () {
            // 后台菜单
            Route::group(['as' => 'menu.', 'prefix' => 'menu'], function () {
                // 菜单列表数据
                /*Route::get('list', 'MenuController@getList')
                    ->name('list');

                // 保存菜单
                Route::post('store', 'MenuController@store')
                    ->name('store');

                // 更新菜单
                Route::post('update', 'MenuController@update')
                    ->name('update');

                // 删除菜单
                Route::delete('{id}', 'MenuController@destroy')
                    ->name('destroy')
                    ->where('id', '[0-9]+');

                // 批量删除菜单
                Route::post('batch/destroy', 'MenuController@batchDestroy')
                    ->name('batch.destroy');*/
            });
        });

        // 管理组
        Route::group([
            'as'        => 'users.',
            'prefix'    => 'users',
            'namespace' => 'Users',
        ], function () {
            // 用户
            Route::group(['as' => 'user.', 'prefix' => 'user'], function () {
                // 用户列表数据
                Route::get('list', 'UserController@getList')
                    ->name('list');

                Route::post('store', 'UserController@store')
                    ->name('store');

                Route::post('update', 'UserController@update')
                    ->name('update');

                Route::delete('{id}', 'UserController@destroy')
                    ->name('destroy')
                    ->where('id', '[0-9]+');

                Route::get('role/all', 'UserController@getAllRole')
                    ->name('role.all');
            });

            // 角色管理
            /*Route::group(['as' => 'role.', 'prefix' => 'role'], function () {
                Route::post('store', 'RoleController@store')
                    ->name('store');

                Route::post('update', 'RoleController@update')
                    ->name('update');

                Route::get('{id}', 'RoleController@get')
                    ->name('get')
                    ->where('id', '[0-9]+');

                Route::delete('{id}', 'RoleController@destroy')
                    ->name('destroy')
                    ->where('id', '[0-9]+');

                // 角色列表
                Route::get('list', 'RoleController@getList')
                    ->name('list');

                Route::get('perms/list', 'RoleController@getPermissionList')
                    ->name('perms.list');

                Route::post('batch/destroy', 'RoleController@batchDestroy')
                    ->name('batch.destroy');
            });*/
        });
    });

    Route::pattern('model', '[a-z_/]+');
    Route::group([
        'middleware' => ['auth', 'admin.phptojs'],
        'prefix' => '{model}',
        'as' => 'model.',
    ], function () {

        Route::get('list', 'AdminController@getList')
            ->name('list')
            ->middleware('admin.can.model:view');

        Route::get('config', 'AdminController@config')
            ->name('config')
            ->middleware('admin.can.model:view');

        Route::get('create', 'AdminController@create')
            ->name('create')
            ->middleware('admin.can.model:create');

        Route::post('store', 'AdminController@store')
            ->name('store')
            ->middleware('admin.can.model:create');

        Route::get('{id}/edit', 'AdminController@edit')
            ->where(['id' => '[0-9]+'])
            ->name('edit')
            ->middleware('admin.can.model:edit');

        Route::post('update', 'AdminController@update')
            ->name('update')
            ->middleware('admin.can.model:edit');

        Route::post('batch/destroy', 'AdminController@batchDestroy')
            ->name('batch.destroy')
            ->middleware('admin.can.model:delete');

        Route::delete('{id}', 'AdminController@destroy')
            ->where(['id' => '[0-9]+'])
            ->name('destroy')
            ->middleware('admin.can.model:delete');

        Route::get('/', function () {
            return view('admin::app');
        })->name('index')
            ->middleware('admin.can.model:view');
    });
});
