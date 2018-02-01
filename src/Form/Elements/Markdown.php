<?php

namespace Sco\Admin\Form\Elements;

/**
 * Class Markdown
 *
 * @package Sco\Admin\Form\Elements
 * @see https://github.com/F-loat/vue-simplemde
 */
class Markdown extends NamedElement
{
    protected $type = 'markdown';

    /**
     * @var array
     */
    protected $configs;

    /**
     * @var bool
     */
    protected $highlight = true;

    /**
     * @var bool
     */
    protected $autoInit = true;

    /**
     * @return array
     */
    public function getConfigs(): array
    {
        if ($this->configs) {
            return $this->configs;
        }

        return $this->getDefaultConfigs();
    }

    /**
     * @return array
     */
    protected function getDefaultConfigs()
    {
        return [
            'autoDownloadFontAwesome' => false,
        ];
    }

    /**
     * @param array $configs
     *
     * @return Markdown
     */
    public function setConfigs(array $configs): Markdown
    {
        $this->configs = $configs;

        return $this;
    }

    /**
     * @return bool
     */
    public function isHighlight(): bool
    {
        return $this->highlight ? true : false;
    }

    /**
     *
     * @return Markdown
     */
    public function disableHighlight(): Markdown
    {
        $this->highlight = false;

        return $this;
    }

    /**
     * @return bool
     */
    public function isAutoInit(): bool
    {
        return $this->autoInit ? true : false;
    }

    /**
     *
     * @return Markdown
     */
    public function disableAutoInit(): Markdown
    {
        $this->autoInit = false;

        return $this;
    }

    public function toArray()
    {
        return parent::toArray() + [
                'configs'   => $this->getConfigs(),
                'highlight' => $this->isHighlight(),
                'autoInit'  => $this->isAutoInit(),
            ];
    }
}
