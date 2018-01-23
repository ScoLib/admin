<?php

namespace Sco\Admin\Form\Elements;

class Image extends BaseFile
{
    protected $type = 'image';

    /**
     * {@inheritdoc}
     */
    public function getValue()
    {
        $value = $this->getValueFromModel();
        if (empty($value) || ! $this->existsFile($value)) {
            return [];
        }

        return $this->getFileInfo($value);
    }

    /**
     * {@inheritdoc}
     */
    protected function prepareValue($value)
    {
        if (empty($value) || ! is_array($value)) {
            return '';
        }

        return $value['path'];
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultExtensions()
    {
        return config('admin.upload.extensions.image');
    }
}
