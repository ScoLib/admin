<?php

namespace Sco\Admin\Contracts;

interface AccessInterface
{
    public function isView();

    public function isCreate();

    public function isEdit();

    public function isDelete();

    public function isDestroy();

    public function isRestore();

    /**
     * @param string $ability
     *
     * @return mixed
     */
    public function can($ability);
}
