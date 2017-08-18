<?php


namespace Sco\Admin\View\Columns;

class Image extends Column
{
    protected $template = '<img v-img :width="value.width" :src="value.image" v-if="value.image">';

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

    public function getModelValue()
    {
        $value = parent::getModelValue();
        if (!empty($value) && (strpos($value, '://') === false)) {
            $value = asset($value);
        }

        return [
            'image' => $value,
            'width' => $this->getImageWidth(),
        ];
    }
}
