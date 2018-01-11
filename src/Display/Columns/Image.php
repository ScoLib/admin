<?php

namespace Sco\Admin\Display\Columns;

use Sco\Admin\Traits\UploadStorageTrait;

class Image extends Column
{
    use UploadStorageTrait;

    protected $type = 'image';

    /**
     * @var string
     */
    protected $imageWidth = '80px';

    /**
     * @return string
     */
    public function getImageWidth()
    {
        return $this->imageWidth;
    }

    /**
     * @param string $width
     *
     * @return $this
     */
    public function setImageWidth($width)
    {
        $this->imageWidth = $width;

        return $this;
    }

    public function getValue()
    {
        $value = parent::getValue();
        if (! empty($value) && (strpos($value, '://') === false)) {
            $value = $this->getFileUrl($value);
        }

        return [
            'image' => $value,
            'width' => $this->getImageWidth(),
        ];
    }

    public function toArray()
    {
        return parent::toArray() + [
                'options' => [
                    'toolbar' => false,
                    'navbar'  => false,
                ],
            ];
    }
}
