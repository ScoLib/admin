<?php

/**
 * @var \KodiComponents\Navigation\Contracts\NavigationInterface $navigation
 */
$navigation->setFromArray([
    [
        'title'    => '系统管理',
        'icon'     => 'fa fa-edit',
        'priority' => 500,
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
        'pages'    => [
            [
                'title' => '用户',
                'icon'  => 'fa fa-user',
                'url'   => route('admin.model.index', ['model' => 'users'], false),
            ],
            [
                'title' => '角色',
                'icon'  => 'fa fa-user-plus',
                'url'   => route('admin.model.index', ['model' => 'roles'], false),
            ],
            [
                'title' => '权限',
                'icon'  => 'fa fa-user',
                'url'   => route('admin.model.index', ['model' => 'permissions'], false),
            ],
        ],
    ],
    [
        'title'    => 'test',
        'icon'     => 'fa fa-edit',
        'priority' => 500,
        'badge'    => 'New',
    ],
]);
