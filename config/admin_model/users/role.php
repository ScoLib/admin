<?php

return [
    'title' => '角色',
    'model' => config('admin.role'),

    'permissions' => [
        'view'   => function () {
            return Auth::user()->can('view_role');
        },
        'create' => function () {
            return Auth::user()->can('create_role');
        },
        'update' => function () {
            return Auth::user()->can('update_role');
        },
        'delete' => function () {
            return Auth::user()->can('delete_role');
        },
    ],
    'columns'     => [
        [
            'key'   => 'id',
            'title' => 'ID',
            'width' => '50',
            'fixed' => false,
        ],
        [
            'key'   => 'name',
            'title' => 'Name',
            'width' => '0',
            'fixed' => false,
        ],
    ],
];
