<?php

return [
    /**
     * Sco Admin Title
     */
    'title' => 'Sco Admin',

    /**
     * Admin Menu
     *
     * [
     *  'model1', // file is "/config/{model_config_dir}/model1.php"
     *  'GroupName' => [
     *      'model1',  // file is "/config/{model_config_dir}/ModelGroup/model1.php"
     *      'model2',  // file is "/config/{model_config_dir}/model2.php"
     *      'title' => 'RouteName',  // admin route name
     *  ],
     * ]
     */
    'menus' => [
        '系统管理' => [
            'logs',
            //'菜单' => 'admin.system.menu',
        ],
        '用户管理' => [
            'users',
            'roles',
            'permissions',
        ],
        //'test',
    ],

    'url_prefix' => 'admin',

    'column' => \Sco\Admin\Column\IvuColumn::class,

];
