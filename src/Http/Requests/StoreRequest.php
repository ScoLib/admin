<?php

namespace Sco\Admin\Http\Requests;

use Illuminate\Validation\Rule;
use Sco\Admin\Contracts\Config as ConfigContract;

class StoreRequest extends BaseFormRequest
{
    protected $configFactory;

    public function __construct(ConfigContract $config)
    {
        parent::__construct();

        $this->configFactory = $config;
    }

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
        return $this->configFactory->getRules();
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
