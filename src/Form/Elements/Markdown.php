<?php

namespace Sco\Admin\Form\Elements;

class Markdown extends NamedElement
{
    protected $type = 'markdown';

    protected $configs;

    protected $highlight = true;

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
