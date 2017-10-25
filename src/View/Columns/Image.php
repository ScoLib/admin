<?php


namespace Sco\Admin\View\Columns;

class Image extends Column
{
    protected $template = '<img v-viewer="column.options" :width="value.width" :src="value.image" v-if="value.image">';

    /**
     * @var string
     */
    protected $imageWidth = '80px';

    protected $disk;

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

    public function getDisk()
    {
        if ($this->disk) {
            return $this->disk;
        }

        return config('admin.upload.disk', 'public');
    }

    public function setDisk($value)
    {
        $this->disk = $value;

        return $this;
    }

    public function getValue()
    {
        $value = parent::getValue();
        if (!empty($value) && (strpos($value, '://') === false)) {
            if (($disk = $this->getDisk())) {
                $value = \Storage::disk($disk)->url($value);
            } else {
                $value = asset($value);
            }
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
