<?php

namespace Sco\Admin\Form\Elements;

class Image extends BaseFile
{
    protected $type = 'image';

    public function getValue()
    {
        $value = $this->getValueFromModel();
        if (empty($value) || ! $this->existsFile($value)) {
            return [];
        }

        return $this->getFileInfo($value);
    }

    protected function prepareValue($value)
    {
        if (empty($value) || ! is_array($value)) {
            return '';
        }

        return $value['path'];
    }

    protected function getDefaultExtensions()
    {
        return config('admin.upload.extensions.image');
    }
}
