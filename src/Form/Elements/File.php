<?php

namespace Sco\Admin\Form\Elements;

use Illuminate\Http\UploadedFile;
use Storage;

class File extends NamedElement
{
    protected $type = 'file';

    protected $actionUrl;

    protected $multiSelect = false;

    protected $multiFile = true;

    protected $showFileList = true;

    protected $withCredentials = false;

    protected $fileSizeLimit = 0;

    protected $fileUploadsLimit = 0;

    protected $fileExtensions;

    protected $listType = 'text';

    protected $disk;

    protected $uploadPath;

    public function getValue()
    {
        $value = parent::getValue();
        if (empty($value)) {
            return [];
        }
        return collect(explode(',', $value))->map(function ($item) {
            return $this->getFileUrl($item);
        });
    }

    public function getActionUrl()
    {
        if ($this->actionUrl) {
            return $this->actionUrl;
        }
        $model = app('admin.components')->get(get_class($this->getModel()));

        $params       = [
            'model' => $model->getName(),
            'field' => $this->getName(),
        ];
        $params['id'] = null;
        if ($this->getModel()->exists) {
            $params['id'] = $this->getModel()->getKey();
        }
        $params['_token'] = csrf_token();

        return route('admin.model.upload.file', $params);
    }

    public function setActionUrl($value)
    {
        $this->actionUrl = $value;

        return $this;
    }

    public function isMultiSelect()
    {
        return $this->multiSelect;
    }

    public function enableMultiSelect()
    {
        $this->multiSelect = true;

        return $this;
    }

    /**
     * Show file list
     *
     * @return $this
     */
    public function disableFileList()
    {
        $this->showFileList = false;

        return $this;
    }

    /**
     * Indicates whether or not cross-site Access-Control requests
     * should be made using credentials
     *
     * @return $this
     */
    public function withCredentials()
    {
        $this->withCredentials = true;

        return $this;
    }

    /**
     * The maximum size allowed for a file upload. (KB)
     *
     * @param int $value
     *
     * @return $this
     */
    public function setFileSizeLimit($value)
    {
        $this->fileSizeLimit = intval($value);
        return $this;
    }

    public function getFileExtensions()
    {
        if ($this->fileExtensions) {
            return $this->fileExtensions;
        }

        return config('admin.upload.extensions');
    }

    /**
     * A list of allowable extensions that can be uploaded.
     *
     * @param array|string $value
     *
     * @return $this
     */
    public function setFileExtensions($value)
    {
        $this->fileExtensions = is_array($value) ? $value : explode(',',
            $value);

        return $this;
    }

    public function getFileUploadsLimit()
    {
        return $this->fileUploadsLimit;
    }

    /**
     * The maximum number of files that can be uploaded.
     *
     * @param int $value
     *
     * @return $this
     */
    public function setFileUploadsLimit($value)
    {
        $this->fileUploadsLimit = intval($value);

        return $this;
    }

    public function getListType()
    {
        return $this->listType;
    }

    public function toArray()
    {
        return parent::toArray() + [
                'action'           => $this->getActionUrl(),
                'showFileList'     => $this->showFileList,
                'multiSelect'      => $this->isMultiSelect(),
                'fileSizeLimit'    => $this->fileSizeLimit,
                'fileUploadsLimit' => $this->getFileUploadsLimit(),
                'fileExtensions'   => $this->getFileExtensions(),
                'listType'         => $this->getListType(),
            ];
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

    public function getUploadPath()
    {
        if ($this->uploadPath) {
            return $this->uploadPath;
        }
        return config('admin.upload.directory', 'admin/uploads');
    }

    public function setUploadPath($value)
    {
        $this->uploadPath = $value;

        return $this;
    }

    public function saveFile(UploadedFile $file)
    {
        $path = $file->store($this->getUploadPath(), $this->getDisk());

        return [
            'path' => $path,
            'url'  => $this->getFileUrl($path),
        ];
    }

    protected function prepareValue($value)
    {
        if (empty($value) && !is_array($value)) {
            return $value;
        }

        return implode(',', $value);
    }

    protected function getFileUrl($path)
    {
        return Storage::disk($this->getDisk())->url($path);
    }
}
