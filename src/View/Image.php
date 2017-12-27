<?php

namespace Sco\Admin\View;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Sco\Admin\Traits\UploadStorageTrait;

class Image extends Table
{
    use UploadStorageTrait;

    protected $type = 'image';

    protected $imagePathAttribute;

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
            $row->setAttribute('_primary', $row->getKey());
            $row->setAttribute('_url', $this->getFileUrl($row->$pathKey));
            return $row;
        });
    }
}
