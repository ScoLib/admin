<?php

namespace Sco\Admin\Form\Elements;

use Illuminate\Http\UploadedFile;
use Sco\Admin\Facades\Admin;
use Sco\Admin\Traits\UploadStorageTrait;
use Validator;

/**
 * Class BaseFile
 *
 * @package Sco\Admin\Form\Elements
 * @see http://element.eleme.io/#/en-US/component/upload
 */
abstract class BaseFile extends NamedElement
{
    use UploadStorageTrait;

    /**
     * @var
     */
    protected $actionUrl;

    /**
     * @var bool
     */
    protected $withCredentials = false;

    /**
     * @var
     */
    protected $maxFileSize;

    /**
     * @var
     */
    protected $fileExtensions;

    /**
     * @var array
     */
    protected $uploadValidationRules = [];

    /**
     * @var array
     */
    protected $uploadValidationMessages = [];

    /**
     * @return mixed
     */
    abstract protected function getDefaultExtensions();

    /**
     * @return string
     */
    public function getActionUrl()
    {
        if ($this->actionUrl) {
            return $this->actionUrl;
        }

        $params = [
            'model' => Admin::component()->getName(),
            'field' => $this->getName(),
        ];
        $params['id'] = null;
        if ($this->getModel()->exists) {
            $params['id'] = $this->getModel()->getKey();
        }
        $params['_token'] = csrf_token();

        return route('admin.model.upload.file', $params);
    }

    /**
     * @param $value
     * @return $this
     */
    public function setActionUrl($value)
    {
        $this->actionUrl = $value;

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

    /**
     * @return float|int
     */
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
    public function setMaxFileSize(int $value)
    {
        $this->maxFileSize = $value;

        $this->addValidationRule('max:' . $this->maxFileSize);

        return $this;
    }

    /**
     * @return mixed
     */
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
    public function setFileExtensions(string $value)
    {
        $this->fileExtensions = $value;

        $this->addValidationRule('mimes:' . $value);

        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return parent::toArray() + [
                'action'           => $this->getActionUrl(),
                'maxFileSize'      => $this->getMaxFileSize(),
                'fileExtensions'   => $this->getFileExtensions(),
            ];
    }

    /**
     * Save file to storage
     *
     * @param \Illuminate\Http\UploadedFile $file
     *
     * @return array
     * @throws \Illuminate\Validation\ValidationException
     */
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

    /**
     * Get file info(name,path,url)
     *
     * @param $path
     *
     * @return array
     */
    protected function getFileInfo($path)
    {
        return [
            'name' => substr($path, strrpos($path, '/') + 1),
            'path' => $path,
            'url'  => $this->getFileUrl($path),
        ];
    }

    /**
     * @param $rule
     * @param null $message
     * @return $this|\Sco\Admin\Form\Elements\BaseFile
     */
    public function addValidationRule($rule, $message = null)
    {
        $uploadRules = [
            'image',
            'mimes',
            'mimetypes',
            'size',
            'dimensions',
            'max',
            'min',
            'between',
        ];

        if (in_array($this->getValidationRuleName($rule), $uploadRules)) {
            return $this->addUploadValidationRule($rule, $message);
        }

        return parent::addValidationRule($rule, $message);
    }

    /**
     * @param $rule
     * @param null $message
     * @return $this|\Sco\Admin\Form\Elements\BaseFile
     */
    protected function addUploadValidationRule($rule, $message = null)
    {
        $this->uploadValidationRules[$this->getValidationRuleName($rule)] = $rule;

        if (is_null($message)) {
            return $this;
        }

        return $this->addUploadValidationMessage($rule, $message);
    }

    /**
     * @param $rule
     * @param $message
     * @return $this
     */
    protected function addUploadValidationMessage($rule, $message)
    {
        $key = $this->getName() . '.' . $this->getValidationRuleName($rule);

        $this->uploadValidationMessages[$key] = $message;

        return $this;
    }

    /**
     * @return array
     */
    protected function getUploadValidationRules()
    {
        $rules = array_merge(
            $this->getDefaultUploadValidationRules(),
            $this->uploadValidationRules
        );

        return [$this->getName() => array_values($rules)];
    }

    /**
     * Get default validation rules
     *
     * @return array
     */
    protected function getDefaultUploadValidationRules()
    {
        return [
            'bail'  => 'bail',
            'file'  => 'file',
            'mimes' => 'mimes:' . $this->getDefaultExtensions(),
            'max'   => 'max:' . $this->getDefaultMaxFileSize(),
        ];
    }

    /**
     * Get validation messages
     *
     * @return array
     */
    protected function getUploadValidationMessages()
    {
        return $this->uploadValidationMessages;
    }

    /**
     * Get validation custom attributes
     *
     * @return array
     */
    protected function getUploadValidationTitles()
    {
        return $this->getValidationTitles();
    }
}
