<?php

namespace Sco\Admin\Form\Elements;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Storage;
use Validator;

class File extends NamedElement
{
    protected $type = 'file';

    protected $actionUrl;

    protected $multiSelect = false;

    protected $multiFile = true;

    protected $showFileList = true;

    protected $withCredentials = false;

    protected $maxFileSize;

    protected $fileUploadsLimit = 0;

    protected $fileExtensions;

    protected $listType = 'text';

    protected $disk;

    /**
     * @var string|\Closure|null
     */
    protected $uploadPath;

    /**
     * @var \Closure|null
     */
    protected $uploadFileNameRule;

    public function getValue()
    {
        $value = parent::getValue();
        if (empty($value)) {
            return [];
        }
        return collect(explode(',', $value))->filter(function ($item) {
            return $this->existsFile($item);
        })->map(function ($item) {
            return $this->getFileInfo($item);
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
     * The maximum size of an uploaded file in bytes
     * If didn't set maximum size, return maximum size as configured in php.ini.
     *
     * @return int
     */
    public function getMaxFileSize()
    {
        if ($this->maxFileSize) {
            return $this->maxFileSize;
        }
        return UploadedFile::getMaxFilesize();
    }

    /**
     * The maximum size allowed for an uploaded file in bytes
     *
     * @param int $value
     *
     * @return $this
     */
    public function setMaxFileSize($value)
    {
        $this->maxFileSize = intval($value);

        return $this;
    }

    public function getFileExtensions()
    {
        if ($this->fileExtensions) {
            return $this->fileExtensions;
        }

        return $this->getDefaultExtensions();
    }

    /**
     * A list of allowable extensions that can be uploaded.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setFileExtensions($value)
    {
        $this->fileExtensions = $value;

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
                'maxFileSize'      => $this->getMaxFileSize(),
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

    protected function getDefaultUploadPath(UploadedFile $file)
    {
        return config('admin.upload.directory', 'admin/uploads');
    }

    public function getUploadPath(UploadedFile $file)
    {
        if (!($path = $this->uploadPath)) {
            $path = $this->getDefaultUploadPath($file);
        }
        if (is_callable($path)) {
            return call_user_func($path, $file);
        }

        return $path;
    }

    /**
     * The path of file save
     *
     * @param string|\Closure $value
     *
     * @return $this
     */
    public function setUploadPath($value)
    {
        $this->uploadPath = $value;

        return $this;
    }

    public function getUploadFileName(UploadedFile $file)
    {
        if (is_callable($this->uploadFileNameRule)) {
            return call_user_func($this->uploadFileNameRule, $file);
        }

        return $this->getDefaultFileName($file);
    }

    protected function getDefaultFileName(UploadedFile $file)
    {
        $hash = Str::random(40);
        return $hash . '.' . $file->guessExtension();
    }

    public function setUploadFileNameRule(\Closure $value)
    {
        $this->uploadFileNameRule = $value;

        return $this;
    }

    public function saveFile(UploadedFile $file)
    {
        Validator::validate(
            [$this->getName() => $file],
            $this->getValidationRules(),
            $this->getValidationMessages(),
            $this->getValidationTitles()
        );

        $path = $file->storeAs(
            $this->getUploadPath($file),
            $this->getUploadFileName($file),
            $this->getDisk()
        );

        return $this->getFileInfo($path);
    }

    protected function prepareValue($value)
    {
        if (empty($value) || !is_array($value)) {
            return '';
        }
        return collect($value)->implode('path', ',');
    }

    protected function existsFile($path)
    {
        return Storage::disk($this->getDisk())->exists($path);
    }

    protected function getFileUrl($path)
    {
        return Storage::disk($this->getDisk())->url($path);
    }

    protected function getFileInfo($path)
    {
        return [
            'name' => substr($path, strrpos($path, '/') + 1),
            'path' => $path,
            'url' => $this->getFileUrl($path),
        ];
    }
}
