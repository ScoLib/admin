<?php

/**
 * @var \KodiComponents\Navigation\Contracts\NavigationInterface $navigation
 */
$navigation->setFromArray([
    [
        'title'    => trans('admin::nav.system'),
        'icon'     => 'fa fa-edit',
        'priority' => 500,
        'id'       => 'system',
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
