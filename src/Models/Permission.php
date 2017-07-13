<?php

namespace Sco\Admin\Models;

use Zizaco\Entrust\EntrustPermission;

/**
 * Sco\Admin\Models\Permission
 *
 * @property int $id 主键
 * @property int $pid 父ID
 * @property string $icon 图标class
 * @property string $display_name 显示名称
 * @property string $name 名称
 * @property bool $is_menu 是否作为菜单
 * @property bool $sort 排序
 * @property string $description 描述
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Sco\Admin\Models\Role[] $roles
 * @method static \Illuminate\Database\Query\Builder|\Sco\Admin\Models\Permission whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Sco\Admin\Models\Permission whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\Sco\Admin\Models\Permission whereDisplayName($value)
 * @method static \Illuminate\Database\Query\Builder|\Sco\Admin\Models\Permission whereIcon($value)
 * @method static \Illuminate\Database\Query\Builder|\Sco\Admin\Models\Permission whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Sco\Admin\Models\Permission whereIsMenu($value)
 * @method static \Illuminate\Database\Query\Builder|\Sco\Admin\Models\Permission whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\Sco\Admin\Models\Permission wherePid($value)
 * @method static \Illuminate\Database\Query\Builder|\Sco\Admin\Models\Permission whereSort($value)
 * @method static \Illuminate\Database\Query\Builder|\Sco\Admin\Models\Permission whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Permission extends EntrustPermission
{
    protected $guarded = ['created_at', 'updated_at'];

    protected $events = [
        'created'  => \Sco\ActionLog\Events\ModelWasCreated::class,
        'updated'  => \Sco\ActionLog\Events\ModelWasUpdated::class,
        'deleted'  => \Sco\ActionLog\Events\ModelWasDeleted::class,
    ];
}
