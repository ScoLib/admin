<?php

namespace Sco\Admin\Models;

use Zizaco\Entrust\EntrustRole;

/**
 * Sco\Admin\Models\Role
 *
 * @property int $id
 * @property string $name 名称
 * @property string $display_name 显示名
 * @property string $description 备注
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Sco\Admin\Models\Permission[] $perms
 * @property-read \Illuminate\Database\Eloquent\Collection|\Sco\Admin\Models\Manager[] $users
 * @method static \Illuminate\Database\Query\Builder|\Sco\Admin\Models\Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Sco\Admin\Models\Role whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\Sco\Admin\Models\Role whereDisplayName($value)
 * @method static \Illuminate\Database\Query\Builder|\Sco\Admin\Models\Role whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Sco\Admin\Models\Role whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\Sco\Admin\Models\Role whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Role extends EntrustRole
{
}
