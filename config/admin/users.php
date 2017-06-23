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
    'columns'     => [
        [
            'key'   => 'id',
            'title' => 'ID',
            'width' => '80',
        ],
        [
            'key'   => 'name',
            'title' => 'Name',
            'width' => '120',
        ],
        [
            'key'   => 'email',
            'title' => 'email',
        ],
        [
            'key'          => 'role_name',
            'title'        => 'roles',
            'relationship' => 'roles',
            'fields'       => 'name,display_name',
            'render'       => function ($model) {
                $render = [];
                foreach ($model->roles as $role) {
                    $render[] = "{$role->display_name}[{$role->name}]";
                }
                return implode('<br>', $render);
            },
        ],
        [
            'key'   => 'created_at',
            'title' => 'created_at',
        ],
    ],
];
