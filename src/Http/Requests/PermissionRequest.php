<?php

namespace Sco\Admin\Http\Requests;

use Illuminate\Contracts\Validation\Validator;

class PermissionRequest extends BaseFormRequest
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
            'pid'          => 'integer',
            'display_name' => 'required|max:50',
            'name'         => ['bail', 'required', 'regex:/^[\w\.#]+$/'],
            'is_menu'      => 'in:0,1',
            'sort'         => 'integer|between:0,255',
        ];
    }

    protected function getMessages()
    {
        return [
            'max'      => trans('admin::validation.max.numeric'),
            'between'  => trans('admin::validation.between.numeric'),
            'different' => '所属父级不能是自己',
        ];
    }

    protected function getAttributes()
    {
        return [
            'name' => '菜单名称',
        ];
    }

    protected function withValidator(Validator $validator)
    {
        $validator->sometimes('pid', 'different:id', function () {
            return !empty($this->input('id'));
        });
    }
}
