<?php

namespace Sco\Admin\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait UploadStorageTrait
{
    /**
     * @var string storage disk name
     */
    protected $disk;

    /**
     * @var string|\Closure|null The relative path of file
     */
    protected $uploadPath;

    /**
     * @var \Closure|null The rule of generate file name
     */
    protected $uploadFileNameRule;

    /**
     * Get Filesystem Disk of the upload file.
     *
     * @return string
     */
    public function getDisk()
    {
        if ($this->disk) {
            return $this->disk;
        }

        return $this->getDefaultDisk();
    }

    protected function getDefaultDisk()
    {
        return config('admin.upload.disk', 'public');
    }

    /**
     * Set Filesystem Disk of the upload file.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setDisk($value)
    {
        $this->disk = $value;

        return $this;
    }

    /**
     * Get a default relative path of the upload file.
     *
     * @param \Illuminate\Http\UploadedFile $file
     *
     * @return string
     */
    protected function getDefaultUploadPath(UploadedFile $file)
    {
        $root = config('admin.upload.directory', 'admin/uploads');

        return rtrim($root, '/') . date('/Y/m/d');
    }

    /**
     * Get relative path of the upload file.
     *
     * @param \Illuminate\Http\UploadedFile $file
     *
     * @return \Closure|mixed|null|string
     */
    public function getUploadPath(UploadedFile $file)
    {
        if ($this->uploadPath) {
            if (is_callable($this->uploadPath)) {
                return call_user_func($this->uploadPath, $file);
            }
            return $this->uploadPath;
        }

        return $this->getDefaultUploadPath($file);
    }

    /**
     * Set relative path of the upload file.
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
     * Get a file name of the upload file.
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

    /**
     * Get a default name of the upload file.
     *
     * @param \Illuminate\Http\UploadedFile $file
     *
     * @return string
     */
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

    protected function existsFile($path)
    {
        return Storage::disk($this->getDisk())->exists($path);
    }

    protected function getFileUrl($path)
    {
        if (($disk = $this->getDisk())) {
            $url = Storage::disk($disk)->url($path);
        } else {
            $url = asset($path);
        }

        return $url;
    }
}
