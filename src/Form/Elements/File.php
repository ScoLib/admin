<?php

namespace Sco\Admin\Form\Elements;

use Illuminate\Http\UploadedFile;
use Sco\Admin\Facades\Admin;
use Sco\Admin\Traits\UploadStorageTrait;
use Validator;

/**
 * Class File
 *
 * @package Sco\Admin\Form\Elements
 */
class File extends BaseFile
{
    /**
     * @var string
     */
    protected $type = 'file';

    /**
     * @var bool
     */
    protected $multiSelect = false;

    /**
     * @var bool
     */
    protected $showFileList = true;

    /**
     * @var int
     */
    protected $fileUploadsLimit = 0;

    /**
     * @return bool
     */
    public function isMultiSelect()
    {
        return $this->multiSelect;
    }

    /**
     * @return $this
     */
    public function enableMultiSelect()
    {
        $this->multiSelect = true;

        return $this;
    }

    /**
     * @return bool
     */
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

    /**
     * @return \Illuminate\Config\Repository|mixed
     */
    protected function getDefaultExtensions()
    {
        return config('admin.upload.extensions.file');
    }

    /**
     * @return int
     */
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

    /**
     * @return array|mixed|static
     */
    public function getValue()
    {
        $value = $this->getValueFromModel();
        if (empty($value)) {
            return [];
        }

        return collect(explode(',', $value))->filter(function ($item) {
            return $this->existsFile($item);
        })->map(function ($item) {
            return $this->getFileInfo($item);
        });
    }

    /**
     * @param mixed $value
     * @return mixed|string
     */
    protected function prepareValue($value)
    {
        if (empty($value) || ! is_array($value)) {
            return '';
        }

        return collect($value)->implode('path', ',');
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return parent::toArray() + [
                'showFileList'     => $this->isShowFileList(),
                'multiSelect'      => $this->isMultiSelect(),
                'fileUploadsLimit' => $this->getFileUploadsLimit(),
            ];
    }
}
