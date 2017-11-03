<?php

namespace Sco\Admin\View;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Image extends Table
{
    protected $type = 'image';

    protected $disk;

    protected $imagePathAttribute;

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

    public function getImagePathAttribute()
    {
        return $this->imagePathAttribute;
    }

    public function setImagePathAttribute($value)
    {
        $this->imagePathAttribute = $value;

        return $this;
    }

    protected function parseRows(Collection $rows)
    {
        if (is_null($pathKey = $this->getImagePathAttribute())) {
            throw new \InvalidArgumentException('Must set image attribute');
        }

        return $rows->map(function (Model $row) use ($pathKey) {
            if (!isset($row->$pathKey)) {
                throw new \InvalidArgumentException("Not Found '{$pathKey}' attribute");
            }

            $path = $row->$pathKey;
            if (($disk = $this->getDisk())) {
                $url = \Storage::disk($disk)->url($path);
            } else {
                $url = asset($path);
            }

            return [
                '_primary' => $row->getKey(),
                'url' => $url,
            ];
        });
    }
}
