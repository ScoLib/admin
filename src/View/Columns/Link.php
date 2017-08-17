<?php


namespace Sco\Admin\View\Columns;

class Link extends Column
{
    protected $template = '<router-link :to="value.url">{{value.title}}</router-link>';

    private $url;

    public function getUrl()
    {
        if ($this->url) {
            return $this->url;
        }
        $model = app('admin.components')->get(get_class($this->getModel()))->getName();
        $id    = $this->getModel()->getKey();
        return route('admin.model.edit', [$model, $id], false);
    }

    public function setUrl($value)
    {
        $this->url = $value;

        return $this;
    }

    public function getModelValue()
    {
        return [
            'url'   => $this->getUrl(),
            'title' => parent::getModelValue(),
        ];
    }
}
