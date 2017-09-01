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

    Route::group(['middleware' => ['auth']], function () {
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

        Route::get('500', [
            'as'   => '500',
            'uses' => function () {
                return view('admin::app');
            },
        ]);
    });

    Route::group(['middleware' => ['auth']], function () {
        Route::get('menu', [
            'as'   => 'menu',
            'uses' => function () {
                return response()->json(AdminNavigation::getPages()->filterByAccessRights());
            },
        ]);
    });

    Route::pattern('model', '[a-z_/]+');
    Route::group([
        'middleware' => ['auth'],
        'prefix'     => '{model}',
        'as'         => 'model.',
    ], function () {
        Route::get('list', [
            'as'         => 'list',
            'uses'       => 'AdminController@getList',
        ]);

        Route::get('config', [
            'as'         => 'config',
            'uses'       => 'AdminController@config',
        ]);

        Route::get('create/info', [
            'as'         => 'create.info',
            'uses'       => 'AdminController@getCreateInfo',
        ]);

        Route::get('create', [
            'as'         => 'create',
            'uses'       => 'AdminController@create',
        ]);

        Route::post('store', [
            'as'         => 'store',
            'uses'       => 'AdminController@store',
        ]);

        Route::get('{id}/edit', [
            'as'         => 'edit',
            'uses'       => 'AdminController@edit',
            'where'      => ['id' => '[0-9]+'],
        ]);

        Route::get('{id}/edit/info', [
            'as'         => 'edit.info',
            'uses'       => 'AdminController@getEditInfo',
            'where'      => ['id' => '[0-9]+'],
        ]);

        Route::post('{id}/edit', [
            'as'         => 'update',
            'uses'       => 'AdminController@update',
            'where'      => ['id' => '[0-9]+'],
        ]);

        /*Route::post('batch/delete', [
            'as'         => 'batch.delete',
            'uses'       => 'AdminController@batchDelete',
        ]);*/

        Route::delete('{id}/delete', [
            'as'         => 'delete',
            'uses'       => 'AdminController@delete',
            'where'      => ['id' => '[0-9]+'],
        ]);

        Route::delete('{id}/destroy', [
            'as'         => 'destroy',
            'uses'       => 'AdminController@forceDelete',
            'where'      => ['id' => '[0-9]+'],
        ]);

        Route::post('{id}/restore', [
            'as'         => 'restore',
            'uses'       => 'AdminController@restore',
            'where'      => ['id' => '[0-9]+'],
        ]);

        Route::post('upload/{field}/{id?}', [
            'as'         => 'upload.file',
            'uses'       => 'UploadController@formElement',
        ]);

        Route::get('/', [
            'as'         => 'index',
            'uses'       => 'AdminController@index',
        ]);
    });
});
