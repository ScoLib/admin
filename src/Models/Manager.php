<?php


namespace Sco\Admin\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;

/**
 * Sco\Admin\Models\Manager
 *
 * @property int $id
 * @property string $name 名称
 * @property string $email 邮箱
 * @property string $password 密码
 * @property string $remember_token
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Sco\Admin\Models\Role[] $roles
 * @method static \Illuminate\Database\Query\Builder|\Sco\Admin\Models\Manager whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Sco\Admin\Models\Manager whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\Sco\Admin\Models\Manager whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Sco\Admin\Models\Manager whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\Sco\Admin\Models\Manager wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\Sco\Admin\Models\Manager whereRememberToken($value)
 * @method static \Illuminate\Database\Query\Builder|\Sco\Admin\Models\Manager whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Manager extends Authenticatable
{
    use EntrustUserTrait;

    protected $visible = ['id', 'name', 'email', 'created_at', 'roles'];

    protected $guarded = ['created_at', 'updated_at'];

    protected $events = [
        'created'  => \Sco\ActionLog\Events\ModelWasCreated::class,
        'updated'  => \Sco\ActionLog\Events\ModelWasUpdated::class,
        'deleted'  => \Sco\ActionLog\Events\ModelWasDeleted::class,
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->table = config('admin.manager_table');
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }
}
