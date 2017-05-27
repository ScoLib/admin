<?php

namespace Sco\Admin\Http\Requests;

use Illuminate\Validation\Rule;

class StoreUserRequest extends BaseFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'     => [
                'bail',
                'required',
                'regex:/^[a-z0-9]+$/i',
                'between:4,20',
                Rule::unique(config('admin.users_table'))
            ],
            'email'    => [
                'bail',
                'email',
                'required',
                Rule::unique(config('admin.users_table')),
            ],
            'password' => 'bail|required|min:6',
        ];
    }

    protected function getMessages()
    {
        return [
            'regex'   => '字母数字',
            'between' => trans('admin::validation.between.string'),
            'min'     => trans('admin::validation.min.string'),
        ];
    }

    protected function getAttributes()
    {
        return [
            'name' => '管理员名称',
        ];
    }
}
