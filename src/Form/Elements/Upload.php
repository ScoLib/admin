<?php

namespace Sco\Admin\Form\Elements;

class Upload extends Element
{
    protected $type = 'upload';

    protected $actionUrl;

    protected $multiple = false;

    protected $showFileList = true;

    protected $withCredentials = false;

    public function getValue()
    {
        $value = parent::getValue();
        if (empty($value)) {
            return [];
        }

        return [
            [
                'name' => '',
                'url'  => asset('vendor/admin/images/1200.jpg'),
            ],
        ];
    }

    public function getActionUrl()
    {
        if ($this->actionUrl) {
            return $this->actionUrl;
        }
        route('admin.dashboard');
    }

    public function setActionUrl($value)
    {
        $this->actionUrl = $value;

        return $this;
    }

    /**
     * Allow multiple selection files
     *
     * @return $this
     */
    public function isMultiple()
    {
        $this->multiple = true;

        return $this;
    }

    /**
     * Do not show file list
     *
     * @return $this
     */
    public function hideFileList()
    {
        $this->showFileList = true;

        return $this;
    }

    /**
     * Indicates whether or not cross-site Access-Control requests
     * should be made using credentials
     *
     * @return $this
     */
    public function withCredentials()
    {
        $this->withCredentials = true;

        return $this;
    }

    public function setMax($value)
    {
        parent::setMax($value);
        $this->addValidationRule('max:' . $value);

        return $this;
    }

    public function toArray()
    {
        return parent::toArray() + [
                'action'       => $this->getActionUrl(),
                'showFileList' => $this->showFileList,
                'multiple'     => $this->multiple,
            ];
    }
}
