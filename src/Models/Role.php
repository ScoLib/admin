<?php

namespace Sco\Admin\Models;

use Zizaco\Entrust\EntrustRole;
use Illuminate\Cache\TaggableStore;
use Cache;
use Config;

class Role extends EntrustRole
{
    protected $fillable = ['name', 'display_name', 'description'];

    /**
     * 保存权限（覆盖父级方法）
     *
     * 增加清除缓存操作
     *
     * @param mixed $inputPermissions
     *
     * @return bool
     */
    public function savePermissions($inputPermissions)
    {
        parent::savePermissions($inputPermissions);

        if (Cache::getStore() instanceof TaggableStore) {
            Cache::tags(Config::get('entrust.permission_role_table'))->flush();
        }
        return true;
    }
}
