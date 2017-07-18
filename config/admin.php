<?php

return [
    /**
     * Sco Admin Title
     */
    'title' => 'Sco Admin',

    'url_prefix' => 'admin',

    'components' => [
        \Sco\Admin\Models\Role::class => \App\Component\Role::class
    ],
];
