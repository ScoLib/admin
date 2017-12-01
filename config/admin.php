<?php

return [
    /**
     * Sco Admin Title
     */
    'title' => 'Sco Admin',

    'url_prefix' => 'admin',

    'datetime_format' => 'Y-m-d H:i:s',

    'upload' => [
        'disk'       => 'public',
        'extensions' => [
            'file'  => 'jpg,gif,png,jpeg,zip,rar,tar,gz,7z,doc,docx,txt,xml',
            'image' => 'jpg,jpeg,png,gif',
        ],
        'directory'  => 'admin/uploads',
    ],

    'components' => app_path('Components'),
];
