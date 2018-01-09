<?php

namespace Sco\Admin\Display;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Sco\Admin\Display\Concerns\WithPagination;
use Sco\Admin\Traits\UploadStorageTrait;

class Image extends Display
{
    use UploadStorageTrait, WithPagination;

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

    public function get()
    {
        if ($this->isPagination()) {
            $data = $this->paginate();

            return $data->setCollection($this->parseRows($data->getCollection()));
        }
        return $this->parseRows($this->getQuery()->get());
    }

    protected function parseRows(Collection $rows)
    {
        if (is_null($pathKey = $this->getImagePathAttribute())) {
            throw new \InvalidArgumentException('Must set image attribute');
        }

        return $rows->map(function (Model $row) use ($pathKey) {
            if (! isset($row->$pathKey)) {
                throw new \InvalidArgumentException("Not Found '{$pathKey}' attribute");
            }
            $row->setAttribute('_primary', $row->getKey());
            $row->setAttribute('_url', $this->getImageUrl($row->$pathKey));

            return $row;
        });
    }

    protected function getImageUrl($value)
    {
        if (! empty($value) && (strpos($value, '://') === false)) {
            $value = $this->getFileUrl($value);
        }

        return $value;
    }
}
