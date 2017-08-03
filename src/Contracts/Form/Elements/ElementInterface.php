<?php


namespace Sco\Admin\Contracts\Form\Elements;

interface ElementInterface
{
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
}
