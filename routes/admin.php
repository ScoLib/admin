<?php

use Sco\Admin\Facades\AdminNavigation;

Route::group([
    'prefix'     => config('admin.url_prefix'),
    'middleware' => 'web',
    'as'         => 'admin.',
], function () {

    // login
    Route::group(['namespace' => 'Auth'], function () {
        // login page
        Route::get('login', [
            'as'   => 'login',
            'uses' => '\Sco\Admin\Http\Controllers\LoginController@showLoginForm',
        ]);

        // submit login
        Route::post('login', [
            'as'   => 'login.submit',
            'uses' => '\Sco\Admin\Http\Controllers\LoginController@login',
        ]);

        // logout
        Route::get('logout', [
            'as'   => 'logout',
            'uses' => '\Sco\Admin\Http\Controllers\LoginController@logout',
        ]);
    });

    Route::group(['middleware' => ['admin.auth']], function () {
        if (!Route::has('admin.dashboard')) {
            Route::view('/', 'admin::app')
                ->name('dashboard');
        }

        foreach (['403', '404', '500'] as $name) {
            Route::view($name, 'admin::app')->name($name);
        }

        Route::get('menu', [
            'as'   => 'menu',
            'uses' => '\Sco\Admin\Http\Controllers\AdminController@getMenu',
        ]);

        Route::pattern('model', '[a-z_]+');
        Route::group([
            'prefix' => '{model}',
            'as'     => 'model.',
        ], function () {
            Route::get('/', [
                'as'   => 'index',
                'uses' => '\Sco\Admin\Http\Controllers\AdminController@index',
            ]);

            // display data
            Route::get('list', [
                'as'   => 'list',
                'uses' => '\Sco\Admin\Http\Controllers\AdminController@getList',
            ]);

            // display config
            Route::get('config', [
                'as'   => 'config',
                'uses' => '\Sco\Admin\Http\Controllers\AdminController@config',
            ]);

            // create form info
            Route::get('create/info', [
                'as'   => 'create.info',
                'uses' => '\Sco\Admin\Http\Controllers\AdminController@getCreateInfo',
            ]);

            // create page
            Route::get('create', [
                'as'   => 'create',
                'uses' => '\Sco\Admin\Http\Controllers\AdminController@create',
            ]);

            // submit create
            Route::post('store', [
                'as'   => 'store',
                'uses' => '\Sco\Admin\Http\Controllers\AdminController@store',
            ]);

            // edit page
            Route::get('{id}/edit', [
                'as'    => 'edit',
                'uses'  => '\Sco\Admin\Http\Controllers\AdminController@edit',
                'where' => ['id' => '[0-9]+'],
            ]);

            // edit form and data info
            Route::get('{id}/edit/info', [
                'as'    => 'edit.info',
                'uses'  => '\Sco\Admin\Http\Controllers\AdminController@getEditInfo',
                'where' => ['id' => '[0-9]+'],
            ]);

            // submit edit
            Route::post('{id}/edit', [
                'as'    => 'update',
                'uses'  => '\Sco\Admin\Http\Controllers\AdminController@update',
                'where' => ['id' => '[0-9]+'],
            ]);

            // delete
            Route::delete('{id}/delete', [
                'as'    => 'delete',
                'uses'  => '\Sco\Admin\Http\Controllers\AdminController@delete',
                'where' => ['id' => '[0-9]+'],
            ]);

            // destroy
            Route::delete('{id}/destroy', [
                'as'    => 'destroy',
                'uses'  => '\Sco\Admin\Http\Controllers\AdminController@forceDelete',
                'where' => ['id' => '[0-9]+'],
            ]);

            // restore
            Route::post('{id}/restore', [
                'as'    => 'restore',
                'uses'  => '\Sco\Admin\Http\Controllers\AdminController@restore',
                'where' => ['id' => '[0-9]+'],
            ]);

            // tree display reorder
            Route::post('reorder', [
                'as'   => 'reorder',
                'uses' => '\Sco\Admin\Http\Controllers\AdminController@reorder',
            ]);

            // form upload file
            Route::post('upload/{field}/{id?}', [
                'as'   => 'upload.file',
                'uses' => '\Sco\Admin\Http\Controllers\UploadController@formElement',
            ]);

        });
    });
});
