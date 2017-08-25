<?php

namespace Sco\Admin\Form\Elements;

class Image extends File
{
    protected $type = 'image';

    protected function getDefaultExtensions()
    {
        return config('admin.upload.extensions.image');
    }
}
