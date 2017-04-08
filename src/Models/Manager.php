<?php


namespace Sco\Admin\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class Manager extends Authenticatable
{
    use EntrustUserTrait;

    protected $visible = ['id', 'name', 'email', 'created_at'];

    protected $guarded = ['created_at', 'updated_at'];
}
