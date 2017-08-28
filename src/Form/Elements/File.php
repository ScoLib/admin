<?php

namespace Sco\Admin\Form\Elements;

use Illuminate\Http\UploadedFile;
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

    protected $uploadValidationRules = [];

    protected $uploadValidationMessages = [];

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
     * The maximum size of an uploaded file in kilobytes
     *
     * @return int
     */
    public function getMaxFileSize()
    {
        if ($this->maxFileSize) {
            return $this->maxFileSize;
        }

        return $this->getDefaultMaxFileSize();
    }

    protected function getDefaultMaxFileSize()
    {
        return UploadedFile::getMaxFilesize() / 1024;
    }

    /**
     * The maximum size allowed for an uploaded file in kilobytes
     *
     * @param int $value
     *
     * @return $this
     */
    public function setMaxFileSize($value)
    {
        $this->maxFileSize = intval($value);

        $this->addValidationRule('max:' . $this->maxFileSize);

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

        $this->addValidationRule('mimes:' . $value);

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
                'showFileList'     => $this->isShowFileList(),
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

    /**
     * Get a filename for the upload file.
     *
     * @param \Illuminate\Http\UploadedFile $file
     *
     * @return mixed|string
     */
    public function getUploadFileName(UploadedFile $file)
    {
        if (is_callable($this->uploadFileNameRule)) {
            return call_user_func($this->uploadFileNameRule, $file);
        }

        return $this->getDefaultFileName($file);
    }

    protected function getDefaultFileName(UploadedFile $file)
    {
        return $file->hashName();
    }

    /**
     * Set the generation rule for the filename of the uploaded file
     *
     * @param \Closure $value
     *
     * @return $this
     */
    public function setUploadFileNameRule(\Closure $value)
    {
        $this->uploadFileNameRule = $value;

        return $this;
    }

    public function saveFile(UploadedFile $file)
    {
        Validator::validate(
            [$this->getName() => $file],
            $this->getUploadValidationRules(),
            $this->getUploadValidationMessages(),
            $this->getUploadValidationTitles()
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
            'url'  => $this->getFileUrl($path),
        ];
    }

    public function addValidationRule($rule, $message = null)
    {
        $uploadRules = [
            'image', 'mimes', 'mimetypes', 'size',
            'dimensions', 'max', 'min', 'between'
        ];

        if (in_array($this->getValidationRuleName($rule), $uploadRules)) {
            return $this->addUploadValidationRule($rule, $message);
        }

        return parent::addValidationRule($rule, $message);
    }

    protected function addUploadValidationRule($rule, $message = null)
    {
        $this->uploadValidationRules[$this->getValidationRuleName($rule)] = $rule;

        if (is_null($message)) {
            return $this;
        }
        return $this->addUploadValidationMessage($rule, $message);
    }

    protected function addUploadValidationMessage($rule, $message)
    {
        $key = $this->getName() . '.' . $this->getValidationRuleName($rule);

        $this->uploadValidationMessages[$key] = $message;

        return $this;
    }

    protected function getUploadValidationRules()
    {
        $rules = array_merge(
            $this->getDefaultUploadValidationRules(),
            $this->uploadValidationRules
        );

        return [$this->getName() => array_values($rules)];
    }

    protected function getDefaultUploadValidationRules()
    {
        return [
            'bail'  => 'bail',
            'file'  => 'file',
            'mimes' => 'mimes:' . $this->getDefaultExtensions(),
            'max'   => 'max:' . $this->getDefaultMaxFileSize(),
        ];
    }

    protected function getUploadValidationMessages()
    {
        return $this->uploadValidationMessages;
    }

    protected function getUploadValidationTitles()
    {
        return $this->getValidationTitles();
    }
}
