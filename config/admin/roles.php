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
        'edit'   => function () {
            return Auth::user()->can('edit_role');
        },
        'delete' => function () {
            return Auth::user()->can('delete_role');
        },
    ],
    'columns'     => [
        [
            'key'   => 'id',
            'title' => 'ID',
        ],
        [
            'key'   => 'name',
            'title' => 'Name',
        ],
        [
            'key'   => 'display_name',
            'title' => 'display_name',
        ],
        [
            'key'   => 'created_at',
            'title' => 'created_at',
        ],
    ],
];
