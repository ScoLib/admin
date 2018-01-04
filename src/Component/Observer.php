<?php

namespace Sco\Admin\Component;

use Sco\Admin\Contracts\ComponentInterface;

class Observer
{
    public function display(ComponentInterface $component)
    {
        return true;
    }

    public function create(ComponentInterface $component)
    {
        return true;
    }

    public function edit(ComponentInterface $component)
    {
        return true;
    }

    public function delete(ComponentInterface $component)
    {
        return true;
    }

    public function destroy(ComponentInterface $component)
    {
        return true;
    }

    public function restore(ComponentInterface $component)
    {
        return true;
    }
}
