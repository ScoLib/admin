<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => ':attribute 必须同意',
    'active_url'           => ':attribute 不是一个真实有效的URL',
    'after'                => ':attribute 必须是 :date 之后的时间',
    'after_or_equal'       => 'The :attribute must be a date after or equal to :date.',
    'alpha'                => ':attribute 必须是字母',
    'alpha_dash'           => ':attribute 必须是字母和数字，以及破折号和下划线',
    'alpha_num'            => ':attribute 必须是字母或数字',
    'array'                => ':attribute 必须是数组',
    'before'               => ':attribute 必须是 :date 之前的时间',
    'before_or_equal'      => 'The :attribute must be a date before or equal to :date.',
    'between'              => [
        'numeric' => ':attribute 大小必须在 :min ~ :max 之间',
        'file'    => ':attribute 文件大小必须在 :min ~ :max KB之间',
        'string'  => ':attribute 长度必须在 :min ~ :max 之间',
        'array'   => ':attribute must have between :min and :max items.',
    ],
    'boolean'              => ':attribute 必须是 true 或 false',
    'confirmed'            => 'The :attribute confirmation does not match.',
    'date'                 => ':attribute 必须是时间',
    'date_format'          => 'The :attribute does not match the format :format.',
    'different'            => 'The :attribute and :other must be different.',
    'digits'               => 'The :attribute must be :digits digits.',
    'digits_between'       => 'The :attribute must be between :min and :max digits.',
    'dimensions'           => 'The :attribute has invalid image dimensions.',
    'distinct'             => 'The :attribute field has a duplicate value.',
    'email'                => ':attribute 格式不正确',
    'exists'               => '选择的 :attribute 不存在',
    'file'                 => 'The :attribute must be a file.',
    'filled'               => 'The :attribute field must have a value.',
    'image'                => ':attribute 必须是图片',
    'in'                   => 'The selected :attribute is invalid.',
    'in_array'             => 'The :attribute field does not exist in :other.',
    'integer'              => ':attribute 必须是整数',
    'ip'                   => ':attribute 格式不正确',
    'json'                 => ':attribute 必须是JSON数据',
    'max'                  => [
        'numeric' => ':attribute may not be greater than :max.',
        'file'    => 'The :attribute may not be greater than :max kilobytes.',
        'string'  => 'The :attribute may not be greater than :max characters.',
        'array'   => 'The :attribute may not have more than :max items.',
    ],
    'mimes'                => 'The :attribute must be a file of type: :values.',
    'mimetypes'            => 'The :attribute must be a file of type: :values.',
    'min'                  => [
        'numeric' => ':attribute 大小必须大于 :min',
        'file'    => ':attribute 文件大小必须大于 :min KB',
        'string'  => ':attribute 长度必须大于 :min 位',
        'array'   => 'The :attribute must have at least :min items.',
    ],
    'not_in'               => 'The selected :attribute is invalid.',
    'numeric'              => ':attribute 必须是数字',
    'present'              => 'The :attribute field must be present.',
    'regex'                => 'The :attribute format is invalid.',
    'required'             => ':attribute 不能为空',
    'required_if'          => 'The :attribute field is required when :other is :value.',
    'required_unless'      => 'The :attribute field is required unless :other is in :values.',
    'required_with'        => 'The :attribute field is required when :values is present.',
    'required_with_all'    => 'The :attribute field is required when :values is present.',
    'required_without'     => 'The :attribute field is required when :values is not present.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    //'same'                 => 'The :attribute and :other must match.',
    'same'                 => '两次 :attribute 输入不一致',
    'size'                 => [
        'numeric' => 'The :attribute must be :size.',
        'file'    => 'The :attribute must be :size kilobytes.',
        'string'  => 'The :attribute must be :size characters.',
        'array'   => 'The :attribute must contain :size items.',
    ],
    'string'               => ':attribute 必须是字符串',
    'timezone'             => 'The :attribute must be a valid zone.',
    'unique'               => '该 :attribute 已存在',
    'uploaded'             => 'The :attribute failed to upload.',
    'url'                  => ':attribute 格式不正确',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [
        'display_name' => '显示名称',
        'email'        => '邮箱',
        'password'     => '密码',
        'repassword'   => '密码',
        'group_id'     => '权限组',
        'name'         => '名称',
        'pid'          => '所属父级',
        'role'         => '角色',
        'icon'         => '图标',
        'sort'         => '排序',
        'description'  => '描述',
    ],

];
