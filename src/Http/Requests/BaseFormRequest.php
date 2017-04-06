<?php


namespace Sco\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BaseFormRequest extends FormRequest
{
    public function messages()
    {
        return [
            'required' => trans('admin::validation.required'),
            'max'      => trans('admin::validation.max.numeric'),
            'regex'    => trans('admin::validation.regex'),
            'between'     => trans('admin::validation.between.numeric'),
        ];
        //return trans('admin::validation');
    }

    public function attributes()
    {
        return trans('admin::validation.attributes');
    }
}
