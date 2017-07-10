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
        Route::get('/', function () {
            return view('admin::app');
        })->name('dashboard')
            ->middleware('admin.can.route');

        Route::get('403', function () {
            return view('admin::app');
        })->name('403');
    });

    Route::group(['middleware' => ['auth']], function () {
        Route::get('menu', function () {
            $menus = Admin::getMenus();
            return response()->json($menus);
        })->name('menu');

        Route::get('check/perm/{name}', function ($name) {
            if (Auth::user()->can($name)) {
                return response()->json(['message' => 'ok']);
            }
            throw new \Illuminate\Auth\Access\AuthorizationException();
        });
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

        Route::post('{id}/edit', 'AdminController@update')
            ->where(['id' => '[0-9]+'])
            ->name('update')
            ->middleware('admin.can.model:edit');

        Route::post('batch/delete', 'AdminController@batchDelete')
            ->name('batch.delete')
            ->middleware('admin.can.model:delete');

        Route::delete('{id}/delete', 'AdminController@delete')
            ->where(['id' => '[0-9]+'])
            ->name('delete')
            ->middleware('admin.can.model:delete');

        Route::delete('{id}/destroy', 'AdminController@forceDelete')
            ->where(['id' => '[0-9]+'])
            ->name('destroy')
            ->middleware('admin.can.model:delete');

        Route::post('{id}/restore', 'AdminController@restore')
            ->where(['id' => '[0-9]+'])
            ->name('restore')
            ->middleware('admin.can.model:restore');

        Route::get('/', function () {
            return view('admin::app');
        })->name('index')
            ->middleware('admin.can.model:view');
    });
});
