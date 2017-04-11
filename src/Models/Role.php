<?php

namespace Sco\Admin\Models;

use Zizaco\Entrust\EntrustRole;
use Illuminate\Cache\TaggableStore;
use Cache;
use Config;

class Role extends EntrustRole
{
    protected $fillable = ['name', 'display_name', 'description'];

}
