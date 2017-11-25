<?php

namespace Sco\Admin\Component;

use Sco\Admin\Contracts\AccessInterface;
use Sco\Admin\Contracts\ComponentInterface;

abstract class Access implements AccessInterface
{
    /**
     * @var \Sco\Admin\Contracts\ComponentInterface
     */
    protected $component;

    private $abilities = [
        'view'    => true,
        'create'  => true,
        'edit'    => true,
        'delete'  => true,
        'destroy' => true,
        'restore' => true,
    ];

    public function __construct(ComponentInterface $component)
    {
        $this->component = $component;
    }

    public function isView()
    {
        return method_exists($this->getComponent(), 'callView')
            && $this->can('view');
    }

    public function isCreate()
    {
        return method_exists($this->getComponent(), 'callCreate')
            && $this->can('create');
    }

    public function isEdit()
    {
        return method_exists($this->getComponent(), 'callEdit')
            && $this->can('edit');
    }

    public function isDelete()
    {
        return $this->can('delete');
    }

    public function isDestroy()
    {
        return $this->isRestorableModel() && $this->can('destroy');
    }

    public function isRestore()
    {
        return $this->isRestorableModel() && $this->can('restore');
    }

    protected function isRestorableModel()
    {
        return $this->getComponent()->getRepository()->isRestorable();
    }

    /**
     * @param string $ability
     *
     * @return mixed
     */
    final public function can($ability)
    {
        if (!isset($this->abilities[$ability])) {
            return false;
        }

        if (is_callable($this->abilities[$ability])) {
            return call_user_func_array(
                $this->abilities[$ability],
                [$this->getComponent()]
            );
        }
        return $this->abilities[$ability] ? true : false;
    }

    protected function getComponent()
    {
        return $this->component;
    }
}
