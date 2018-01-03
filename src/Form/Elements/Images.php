<?php

namespace Sco\Admin\Form\Elements;

class Images extends File
{
    protected $type = 'images';

    protected $listType = 'picture';

    public function getListType()
    {
        return $this->listType;
    }

    public function cardListType()
    {
        $this->listType = 'picture-card';

        return $this;
    }

    protected function getDefaultExtensions()
    {
        return config('admin.upload.extensions.image');
    }

    public function toArray()
    {
        return parent::toArray() + [
                'listType' => $this->getListType(),
            ];
    }
}
