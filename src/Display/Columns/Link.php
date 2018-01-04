<?php

namespace Sco\Admin\Display\Columns;

use Sco\Admin\Facades\Admin;

class Link extends Column
{
    protected $template = '<router-link :to="value.url">{{value.title}}</router-link>';

    private $url;

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
