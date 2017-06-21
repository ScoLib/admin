<?php

return [
    'title' => '操作日志',
    'model' => \Sco\ActionLog\Models\ActionLogModel::class,

    'permissions' => function () {
        return Auth::user()->can('manage_log');
    },
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
