<?php
return [

    /**
     *
     */
    'action_logs_table' => 'action_logs',

    /**
     * Application User Model
     *
     * This is the User model used by ActionLog to create correct relations.
     * Update the User if it is in a different namespace.
     *
     */
    'user' => \Sco\Admin\Models\User::class,

    /**
     * ActionLog user foreign key
     *
     * This is the user foreign key used by ActionLog to make a proper
     * relation between action logs and users
     */
    'user_foreign_key' => 'user_id',

    /**
     *
     */
    'guest' => true,
];
