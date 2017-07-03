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
        'id'         => [
            'title'    => 'ID',
            'sortable' => true,
            'width'    => '60',
        ],
        'user'       => [
            'title'        => 'User',
            'width'        => '120',
            'relationship' => 'user',
            'fields'       => 'id,name',
            'template'     => '<span><template v-if="value.length == 0">guest / 0</template><template v-else>{{value.name}} / {{value.id}}</template></span>',
        ],
        'type'       => [
            'title' => 'Type',
        ],
        'content'    => [
            'title' => 'content',
        ],
        'client_ip'  => [
            'title' => 'client_ip',
        ],
        'client'     => [
            'title' => 'client',
        ],
        'created_at' => [
            'title'  => 'Created At',
            'format' => 'humans',
        ],
    ],

];
