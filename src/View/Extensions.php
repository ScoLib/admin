<?php

namespace Sco\Admin\View;

use Illuminate\Support\Collection;
use Sco\Admin\Contracts\Initializable;
use Sco\Admin\Contracts\View\Extensions\ExtensionInterface;

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
