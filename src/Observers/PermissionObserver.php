<?php


namespace Sco\Admin\Observers;

use Cache;
use Sco\Admin\Models\Permission;

class PermissionObserver
{
    public function saved(Permission $permission)
    {
        $this->clearCache();
    }

    public function deleted(Permission $permission)
    {
        $this->clearCache();
    }

    private function clearCache()
    {
        Cache::forget('permission_all');
    }
}
