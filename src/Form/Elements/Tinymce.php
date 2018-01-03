<?php

namespace Sco\Admin\Form\Elements;

/**
 * @see https://www.tinymce.com/
 */
class Tinymce extends NamedElement
{
    protected $type = 'tinymce';

    protected $size = 'basic';

    protected $options = [];

    protected $baseUrl;

    protected $plugins;

    public function basicToolbar()
    {
        $this->size = 'basic';

        return $this;
    }

    public function simpleToolbar()
    {
        $this->size = 'simple';

        return $this;
    }

    /**
     * @param array $toolbar
     *
     * @return Tinymce
     */
    public function setToolbar(array $toolbar)
    {
        $this->options['toolbar'] = $toolbar;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getBaseUrl()
    {
        if ($this->baseUrl) {
            return $this->baseUrl;
        }

        return url('js/tinymce');
    }

    /**
     * @param mixed $baseUrl
     *
     * @return Tinymce
     */
    public function setBaseUrl($baseUrl)
    {
        $this->baseUrl = $baseUrl;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPlugins()
    {
        return $this->plugins;
    }

    /**
     * @param mixed $plugins
     *
     * @return Tinymce
     */
    public function setPlugins($plugins)
    {
        $this->plugins = $plugins;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param mixed $options
     *
     * @return Tinymce
     */
    public function setOptions($options)
    {
        $this->options = $options;

        return $this;
    }

    public function toArray()
    {
        $data = [
            'size'    => $this->size,
            'baseUrl' => $this->getBaseUrl(),
            'options' => $this->getOptions(),
        ];
        if (($plugins = $this->getPlugins())) {
            $data['plugins'] = $plugins;
        }

        return parent::toArray() + $data;
    }
}
