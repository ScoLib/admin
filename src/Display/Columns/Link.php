<?php

namespace Sco\Admin\Display\Columns;

use Sco\Admin\Facades\Admin;

class Link extends Column
{
    protected $type = 'link';

    protected $url;

    public function getUrl()
    {
        if ($this->url) {
            return $this->url;
        }

        return $this->getEditUrl();
    }

    public function setUrl($value)
    {
        $this->url = $value;

        return $this;
    }

    protected function getEditUrl()
    {
        $model = Admin::component()->getName();
        $id = $this->getModel()->getKey();

        return route('admin.model.edit', [$model, $id], false);
    }

    public function getValue()
    {
        return [
            'url'   => $this->getUrl(),
            'title' => parent::getValue(),
        ];
    }
}
