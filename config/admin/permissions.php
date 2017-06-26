<?php

return [
    'title' => '权限',
    'model' => config('admin.permission'),

    'permissions' => [
        'view'   => function () {
            return Auth::user()->can('view_permission');
        },
        'create' => function () {
            return Auth::user()->can('create_permission');
        },
        'edit'   => function () {
            return Auth::user()->can('edit_permission');
        },
        'delete' => function () {
            return Auth::user()->can('delete_permission');
        },
    ],
    'columns'     => [
        'id'           => [
            'title' => 'ID',
        ],
        'name'         => [
            'title' => 'Name',
        ],
        'display_name' => [
            'title' => 'display_name',
        ],
        'created_at'   => [
            'title' => 'created_at',
        ],
    ],
];
