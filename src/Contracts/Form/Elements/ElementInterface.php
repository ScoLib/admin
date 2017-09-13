<?php

namespace Sco\Admin\Contracts\Form\Elements;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use JsonSerializable;
use Sco\Admin\Contracts\WithModel;

interface ElementInterface extends
    WithModel,
    Arrayable,
    Jsonable,
    JsonSerializable
{
    /**
     * Get Element Value
     *
     * @return mixed
     */
    public function getValue();

    public function getName();

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setName($value);

    public function getTitle();

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setTitle($value);

    public function save();

    public function finishSave();
}
