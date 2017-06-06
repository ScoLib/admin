<?php

return [
    'title'=> '操作日志',
    'model' => \Sco\ActionLog\Models\ActionLogModel::class,

    'permissions' => function () {
        return true;
        return Auth::user()->can('manage_log');
    }
];