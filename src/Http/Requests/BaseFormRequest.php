<?php


namespace Sco\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BaseFormRequest extends FormRequest
{
    public function messages()
    {
        return array_merge(trans('admin::validation'), $this->getMessages());
    }

    public function attributes()
    {
        return array_merge(trans('admin::validation.attributes'), $this->getAttributes());
    }

    protected function getMessages()
    {
        return [];
    }

    protected function getAttributes()
    {
        return [];
    }
}
