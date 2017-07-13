<?php

Route::group([
    'prefix'     => config('admin.url_prefix'),
    'middleware' => 'web',
    'namespace'  => '\Sco\Admin\Http\Controllers',
    'as'         => 'admin.',
], function () {

    // 登录
    Route::group(['namespace' => 'Auth'], function () {
        //登录页
        Route::get('login', [
            'as'         => 'login',
            'uses'       => 'LoginController@showLoginForm',
            'middleware' => 'admin.phptojs',
        ]);

        //登录提交
        Route::post('login', [
            'as'   => 'login.submit',
            'uses' => 'LoginController@login',
        ]);

        //退出
        Route::get('logout', [
            'as'   => 'logout',
            'uses' => 'LoginController@logout',
        ]);
    });

    Route::group(['middleware' => ['auth', 'admin.phptojs']], function () {
        Route::get('/', [
            'as'         => 'dashboard',
            'uses'       => function () {
                return view('admin::app');
            },
            'middleware' => 'admin.can.route',
        ]);

        Route::get('403', [
            'as'   => '403',
            'uses' => function () {
                return view('admin::app');
            },
        ]);
    });

    Route::group(['middleware' => ['auth']], function () {
        Route::get('menu', [
            'as'   => 'menu',
            'uses' => function () {
                return response()->json(AdminNavigation::getPages());
            },
        ]);

        /*Route::get('check/perm/{name}', [
            'as' => 'checkperm',
            'uses' => function ($name) {
                if (Auth::user()->can($name)) {
                    return response()->json(['message' => 'ok']);
                }
                throw new \Illuminate\Auth\Access\AuthorizationException();
            }
        ]);*/
    });

    /*Route::group(['middleware' => ['auth']], function () {

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
                    ->name('batch.destroy');
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
            Route::group(['as' => 'role.', 'prefix' => 'role'], function () {
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
            });
        });
    });*/

    Route::pattern('model', '[a-z_/]+');
    Route::group([
        'middleware' => ['auth', 'admin.phptojs'],
        'prefix'     => '{model}',
        'as'         => 'model.',
    ], function () {
        Route::get('list', [
            'as'   => 'list',
            'uses' => 'AdminController@getList',
        ])->middleware('admin.can.model:view');

        Route::get('config', [
            'as'   => 'config',
            'uses' => 'AdminController@config',
        ])->middleware('admin.can.model:view');

        Route::get('create', [
            'as'         => 'create',
            'uses'       => 'AdminController@create',
            'middleware' => 'admin.can.model:create',
        ]);

        Route::post('store', [
            'as'         => 'store',
            'uses'       => 'AdminController@store',
            'middleware' => 'admin.can.model:create',
        ]);

        Route::get('{id}/edit', [
            'as'         => 'edit',
            'uses'       => 'AdminController@edit',
            'middleware' => 'admin.can.model:edit',
            'where'      => ['id' => '[0-9]+'],
        ]);

        Route::post('{id}/edit', [
            'as'         => 'update',
            'uses'       => 'AdminController@update',
            'middleware' => 'admin.can.model:edit',
            'where'      => ['id' => '[0-9]+'],
        ]);

        Route::post('batch/delete', [
            'as'         => 'batch.delete',
            'uses'       => 'AdminController@batchDelete',
            'middleware' => 'admin.can.model:delete',
        ]);

        Route::delete('{id}/delete', [
            'as'         => 'delete',
            'uses'       => 'AdminController@delete',
            'middleware' => 'admin.can.model:delete',
            'where'      => ['id' => '[0-9]+'],
        ]);

        Route::delete('{id}/destroy', [
            'as'         => 'destroy',
            'uses'       => 'AdminController@forceDelete',
            'middleware' => 'admin.can.model:delete',
            'where'      => ['id' => '[0-9]+'],
        ]);

        Route::post('{id}/restore', [
            'as'         => 'restore',
            'uses'       => 'AdminController@restore',
            'middleware' => 'admin.can.model:restore',
            'where'      => ['id' => '[0-9]+'],
        ]);

        Route::get('/', [
            'as'         => 'index',
            'uses'       => 'AdminController@index',
            'middleware' => 'admin.can.model:view',
        ]);
    });
});
