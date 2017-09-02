<?php


namespace Sco\Admin\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Authenticatable
{
    use EntrustUserTrait;

    protected $visible = ['id', 'name', 'email', 'created_at', 'roles'];

    protected $guarded = ['created_at', 'updated_at'];

    protected $hidden = ['password'];

    protected $fillable = ['name', 'email', 'password'];

    public function setPasswordAttribute($value)
    {
        if (empty($value)) {
            return;
        }
        $this->attributes['password'] = bcrypt($value);
    }
}
