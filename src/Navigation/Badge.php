<?php

namespace Sco\Admin\Navigation;

class Badge extends \KodiComponents\Navigation\Badge
{
    public function toArray()
    {
        if (! $this->hasClassProperty('label-', 'bg-')) {
            $this->setHtmlAttribute('class', 'label-primary');
        }

        return ['value' => $this->getValue()] + $this->getHtmlAttributes();
    }
}
