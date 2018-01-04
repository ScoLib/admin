<?php

namespace Sco\Admin\Display;

use Illuminate\Support\Collection;
use Sco\Admin\Contracts\Initializable;
use Sco\Admin\Contracts\Display\Extensions\ExtensionInterface;

class Extensions extends Collection
{
    public function initialize()
    {
        $this->each(function (ExtensionInterface $extension) {
            if ($extension instanceof Initializable) {
                $extension->initialize();
            }
        });
    }

    public function apply($query)
    {
        $this->each(function (ExtensionInterface $extension) use ($query) {
            $extension->apply($query);
        });
    }
}
