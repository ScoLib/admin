<?php

return [
    'title' => '操作日志',
    'model' => \Sco\ActionLog\Models\ActionLogModel::class,

    'permissions' => [
        'view'   => function () {
            return Auth::user()->can('manage_log');
        },
        'create' => function () {
            return false;
        },
        'edit'   => function () {
            return false;
        },
        'delete' => function () {
            return false;
        },
    ],
    'columns'     => [
        'id' => [
            'title' => 'ID',
        ],
        'user' => [
            'title' => 'User',
            'relationship' => 'user',
            'fields'       => 'name',
        ],
        'type' => [
            'title' => 'Type',
        ],
        'content' => [
            'title' => 'content',
        ],
        'client_ip' => [
            'title' => 'client_ip',
        ],
        'client' => [
            'title' => 'client',
        ],
    ],

];
