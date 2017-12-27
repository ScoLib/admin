<?php

use Sco\Admin\Facades\AdminNavigation;

Route::group([
    'prefix'     => config('admin.url_prefix'),
    'middleware' => 'web',
    'as'         => 'admin.',
], function () {

    // 登录
    Route::group(['namespace' => 'Auth'], function () {
        //登录页
        Route::get('login', [
            'as'   => 'login',
            'uses' => '\Sco\Admin\Http\Controllers\LoginController@showLoginForm',
        ]);

        //登录提交
        Route::post('login', [
            'as'   => 'login.submit',
            'uses' => '\Sco\Admin\Http\Controllers\LoginController@login',
        ]);

        //退出
        Route::get('logout', [
            'as'   => 'logout',
            'uses' => '\Sco\Admin\Http\Controllers\LoginController@logout',
        ]);
    });

    Route::group(['middleware' => ['admin.auth']], function () {
        Route::view('/', 'admin::app')
            ->name('dashboard')
            ->middleware('admin.can.route');

        Route::view('403', 'admin::app')->name('403');
        Route::view('500', 'admin::app')->name('500');
        Route::view('404', 'admin::app')->name('404');

        Route::get('menu', [
            'as'   => 'menu',
            'uses' => function () {
                $pages = AdminNavigation::filterByAccessRights()->sort()->getPages();
                return response()->json($pages);
            },
        ]);

        Route::pattern('model', '[a-z_/]+');
        Route::group([
            'prefix' => '{model}',
            'as'     => 'model.',
        ], function () {
            Route::get('list', [
                'as'   => 'list',
                'uses' => '\Sco\Admin\Http\Controllers\AdminController@getList',
            ]);

            Route::get('config', [
                'as'   => 'config',
                'uses' => '\Sco\Admin\Http\Controllers\AdminController@config',
            ]);

            Route::get('create/info', [
                'as'   => 'create.info',
                'uses' => '\Sco\Admin\Http\Controllers\AdminController@getCreateInfo',
            ]);

            Route::get('create', [
                'as'   => 'create',
                'uses' => '\Sco\Admin\Http\Controllers\AdminController@create',
            ]);

            Route::post('store', [
                'as'   => 'store',
                'uses' => '\Sco\Admin\Http\Controllers\AdminController@store',
            ]);

            Route::get('{id}/edit', [
                'as'    => 'edit',
                'uses'  => '\Sco\Admin\Http\Controllers\AdminController@edit',
                'where' => ['id' => '[0-9]+'],
            ]);

            Route::get('{id}/edit/info', [
                'as'    => 'edit.info',
                'uses'  => '\Sco\Admin\Http\Controllers\AdminController@getEditInfo',
                'where' => ['id' => '[0-9]+'],
            ]);

            Route::post('{id}/edit', [
                'as'    => 'update',
                'uses'  => '\Sco\Admin\Http\Controllers\AdminController@update',
                'where' => ['id' => '[0-9]+'],
            ]);

            /*Route::post('batch/delete', [
                'as'         => 'batch.delete',
                'uses'       => '\Sco\Admin\Http\Controllers\AdminController@batchDelete',
            ]);*/

            Route::delete('{id}/delete', [
                'as'    => 'delete',
                'uses'  => '\Sco\Admin\Http\Controllers\AdminController@delete',
                'where' => ['id' => '[0-9]+'],
            ]);

            Route::delete('{id}/destroy', [
                'as'    => 'destroy',
                'uses'  => '\Sco\Admin\Http\Controllers\AdminController@forceDelete',
                'where' => ['id' => '[0-9]+'],
            ]);

            Route::post('{id}/restore', [
                'as'    => 'restore',
                'uses'  => '\Sco\Admin\Http\Controllers\AdminController@restore',
                'where' => ['id' => '[0-9]+'],
            ]);

            Route::post('reorder', [
                'as'   => 'reorder',
                'uses' => '\Sco\Admin\Http\Controllers\AdminController@reorder',
            ]);

            Route::post('upload/{field}/{id?}', [
                'as'   => 'upload.file',
                'uses' => '\Sco\Admin\Http\Controllers\UploadController@formElement',
            ]);

            Route::get('/', [
                'as'   => 'index',
                'uses' => '\Sco\Admin\Http\Controllers\AdminController@index',
            ]);
        });
    });
});
