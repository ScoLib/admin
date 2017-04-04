<?php

namespace Sco\Admin\Http\Requests;

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
            'pid'          => 'integer',
            'display_name' => 'required|max:5',
            'name'         => ['bail', 'required', 'regex:/^[\w\.#]+$/'],
            'sort'         => 'integer|between:0,255',
        ];
    }
}
