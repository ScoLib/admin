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
        $value = parent::getValue();
        if (empty($value) || ! $this->existsFile($value)) {
            return [];
        }

        return $this->getFileInfo($value);
    }

    protected function mutateValueAsPath()
    {
        $this->setMutator(function ($value) {
            return empty($value) || ! is_array($value) ? '' : $value['path'];
        });
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultExtensions()
    {
        return config('admin.upload.extensions.image');
    }
}
