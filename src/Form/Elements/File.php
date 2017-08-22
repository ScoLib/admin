<?php

namespace Sco\Admin\Form\Elements;

class File extends Element
{
    protected $type = 'file';

    protected $actionUrl;

    protected $multiple = false;

    protected $showFileList = true;

    protected $withCredentials = false;

    protected $fileSizeLimit = 0;

    protected $fileUploadsLimit = 0;

    protected $fileExts;

    public function getValue()
    {
        $value = parent::getValue();
        if (empty($value)) {
            return [];
        }

        return [
            [
                'name' => '',
                'url'  => asset('vendor/admin/images/1200.jpg'),
            ],
        ];
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

    /**
     * Allow multiple selection files
     *
     * @return $this
     */
    public function isMultiple()
    {
        $this->multiple = true;

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

    public function getFileExts()
    {
        if ($this->fileExts) {
            return $this->fileExts;
        }

        return config('admin.defaultFileExts');
    }

    /**
     * A list of allowable extensions that can be uploaded.
     *
     * @param array|string $value
     *
     * @return $this
     */
    public function setFileExts($value)
    {
        $this->fileExts = is_array($value) ? $value : explode(',', $value);

        return $this;
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

    public function toArray()
    {
        return parent::toArray() + [
                'action'           => $this->getActionUrl(),
                'showFileList'     => $this->showFileList,
                'multiple'         => $this->multiple,
                'fileSizeLimit'    => $this->fileSizeLimit,
                'fileUploadsLimit' => $this->fileUploadsLimit,
                'fileExts'         => $this->getFileExts(),
            ];
    }
}
