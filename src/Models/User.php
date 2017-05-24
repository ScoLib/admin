<?php


namespace Sco\Admin\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Sco\Admin\Traits\EntrustPermissionTrait;
use Sco\Admin\Traits\ModelEventTrait;

class User extends Authenticatable
{
    use EntrustPermissionTrait, ModelEventTrait;

    protected $visible = ['id', 'name', 'email', 'created_at', 'roles'];

    protected $guarded = ['created_at', 'updated_at'];

    protected $hidden = ['password'];


    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->table = config('admin.users_table');
    }
}
