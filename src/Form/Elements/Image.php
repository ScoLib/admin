<?php

namespace Sco\Admin\Form\Elements;

class Image extends BaseFile
{
    protected $type = 'image';

    protected function getDefaultExtensions()
    {
        return config('admin.upload.extensions.image');
    }
}
