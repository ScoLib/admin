<?php

namespace Sco\Admin\View;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Image extends Table
{
    protected $type = 'image';

    protected $disk;

    protected $imageAttributeValue;

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

    public function getImageAttributeValue()
    {
        return $this->imageAttributeValue;
    }

    public function setImageAttributeValue($value)
    {
        $this->imageAttributeValue = $value;

        return $this;
    }

    protected function parseRows(Collection $rows)
    {
        if (is_null($key = $this->getImageAttributeValue())) {
            throw new \InvalidArgumentException('must set image attribute');
        }

        return $rows->map(function (Model $row) use ($key) {
            $path = $row->$key;
            if (($disk = $this->getDisk())) {
                $url = \Storage::disk($disk)->url($path);
            } else {
                $url = asset($path);
            }

            return [
                'id' => $row->id,
                'url' => $url,
            ];
        });
    }
}
