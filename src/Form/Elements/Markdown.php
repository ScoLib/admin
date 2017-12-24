<?php

namespace Sco\Admin\Form\Elements;

/**
 * @see https://github.com/hinesboy/mavonEditor
 */
class Markdown extends NamedElement
{
    protected $type = 'markdown';

    protected $configs;

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
     * @return Simplemde
     */
    public function setConfigs(array $configs): Simplemde
    {
        $this->configs = $configs;

        return $this;
    }

    public function toArray()
    {
        return parent::toArray() + [
                'configs' => $this->getConfigs(),
            ];
    }
}
