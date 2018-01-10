<?php

namespace Sco\Admin\Form\Elements;

use Illuminate\Http\UploadedFile;
use Sco\Admin\Facades\Admin;
use Sco\Admin\Traits\UploadStorageTrait;
use Validator;

class File extends BaseFile
{
    protected $type = 'file';

    protected $multiSelect = false;

    protected $showFileList = true;

    protected $fileUploadsLimit = 0;

    public function isMultiSelect()
    {
        return $this->multiSelect;
    }

    public function enableMultiSelect()
    {
        $this->multiSelect = true;

        return $this;
    }

    public function isShowFileList()
    {
        return $this->showFileList;
    }

    /**
     * Disable file list
     *
     * @return $this
     */
    public function disableFileList()
    {
        $this->showFileList = false;

        return $this;
    }

    protected function getDefaultExtensions()
    {
        return config('admin.upload.extensions.file');
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
    public function setFileUploadsLimit(int $value)
    {
        $this->fileUploadsLimit = $value;

        return $this;
    }

    public function toArray()
    {
        return parent::toArray() + [
                'showFileList'     => $this->isShowFileList(),
                'multiSelect'      => $this->isMultiSelect(),
                'fileUploadsLimit' => $this->getFileUploadsLimit(),
            ];
    }
}
