<?php

return [
    'title' => '用户',
    'model' => config('admin.user'),

    'permissions' => [
        'view'   => function () {
            return Auth::user()->can('view_user');
        },
        'create' => function () {
            return Auth::user()->can('create_user');
        },
        'edit'   => function () {
            return Auth::user()->can('edit_user');
        },
        'delete' => function () {
            return Auth::user()->can('delete_user');
        },
    ],
    'columns'     => [],
];
