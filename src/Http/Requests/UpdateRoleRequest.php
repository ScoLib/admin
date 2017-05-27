<?php

namespace Sco\Admin\Http\Requests;

use Illuminate\Validation\Rule;

class UpdateRoleRequest extends BaseFormRequest
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
            'id'           => 'integer',
            'name'         => [
                'bail',
                'required',
                'regex:/^[a-z0-9]+$/i',
                'max: 50',
                Rule::unique(config('admin.roles_table'))->ignore($this->input('id')),
            ],
            'display_name' => [
                'bail',
                'required',
                'alpha_num',
            ],
            'description' => [
                'bail',
                'alpha_num',
            ],
        ];
    }

    protected function getMessages()
    {
        return [
            'max'   => trans('admin::validation.max.string'),
            'regex' => '字母数字',
        ];
    }

    protected function getAttributes()
    {
        return [
            'name' => '标识',
        ];
    }
}
