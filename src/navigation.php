<?php

/**
 * @var \KodiComponents\Navigation\Contracts\NavigationInterface $navigation
 */
$navigation->setFromArray([
    [
        'title'    => '系统管理',
        'icon'     => 'fa fa-edit',
        'priority' => 500,
        'id'       => 'system',
        'pages'    => [
            [
                'title' => '操作日志',
                'url'   => route('admin.model.index', ['model' => 'logs'], false),
            ],
        ],
    ],
    [
        'title'    => '用户管理',
        'icon'     => 'fa fa-users',
        'priority' => 600,
        'badge'    => 'New',
        'id'       => 'users',
    ],
    [
        'title'    => 'test',
        'icon'     => 'fa fa-edit',
        'priority' => 500,
        'badge'    => 'New',
    ],
]);
