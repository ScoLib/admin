<?php

return [
    'title' => '角色',
    'model' => [
        'class'   => config('entrust.role'),
        'perPage' => 0,
    ],

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
        'id'           => [
            'title' => 'ID',
            'width' => '80',
        ],
        'name'         => [
            'title' => 'Name',
            'width' => '120',
        ],
        'display_name' => [
            'title' => 'display_name',
        ],
        'created_at'   => [
            'title'  => 'created_at',
            'format' => 'Y/m/d',
        ],
        'permissions'  => [
            'title'        => 'Perm',
            'relationship' => 'perms',
            'fields'       => 'id,display_name',
        ],
    ],

    'elements' => [
        'name'         => [
            'title' => 'Name',
        ],
        'display_name' => [
            'title' => 'Display Name',
        ],
        'description'  => [
            'title' => 'Description',
        ],
        'perms'        => [
            'title'        => 'Permission',
            'type'         => 'select',
            'relationship' => 'perms',
            'fields'       => 'display_name',
        ],
    ],
];
