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
        [
            'key'   => 'id',
            'title' => 'ID',
        ],
        [
            'key'   => 'type',
            'title' => 'Type',
        ],
        [
            'key'   => 'content',
            'title' => 'content',
        ],
        [
            'key'   => 'client_ip',
            'title' => 'client_ip',
        ],
        [
            'key'   => 'client',
            'title' => 'client',
        ],
    ],

];
