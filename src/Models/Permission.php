<?php

namespace Sco\Admin\Models;

use DB;
use Cache;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Sco\Admin\Observers\PermissionObserver;
use Sco\Tree\Traits\TreeTrait;
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
    use TreeTrait;

    protected $guarded = ['created_at', 'updated_at'];

    protected $treeNodeParentIdName = 'pid';

    private $allRoutes = null;

    private $permList = null;

    private $menuList = null;

    protected $fillable = ['pid', 'display_name', 'name', 'icon', 'is_menu', 'sort', 'description'];

    protected $events = [
        'created'  => \Sco\ActionLog\Events\ModelWasCreated::class,
        'updated'  => \Sco\ActionLog\Events\ModelWasUpdated::class,
        'deleted'  => \Sco\ActionLog\Events\ModelWasDeleted::class,
    ];


    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('admin.permissions_table');
    }


    /**
     * @return \Illuminate\Support\Collection
     */
    public function getMenuTreeList()
    {
        $routes = $this->getDescendants(0);
        //dd($routes);
        return $routes;
    }

    private function getAll()
    {
        if ($this->allRoutes) {
            return $this->allRoutes;
        }

        $this->allRoutes = Cache::rememberForever(
            'permission_all',
            function () {
                return $this->orderBy('sort')->get();
            }
        );
        return $this->allRoutes;
    }

    /**
     * Tree Trait 获取所有节点
     *
     * @return mixed|null
     */
    protected function getTreeAllNodes()
    {
        return $this->getAll();
    }

    /**
     * 获取权限列表
     *
     * @return \Illuminate\Support\Collection|null
     */
    public function getPermRouteList()
    {
        if ($this->permList) {
            return $this->permList;
        }

        return $this->permList = $this->getLayerOfDescendants(0);
    }

    public function getMenuList()
    {
        if ($this->menuList) {
            return $this->menuList;
        }
        $all = $this->getAll();

        $routes = collect([]);
        foreach ($all as $route) {
            if ($route->is_menu) {
                $routes->push($route);
            }
        }

        $this->setAllNodes($routes);
        return $this->menuList = $this->getLayerOfDescendants(0);
    }

    /**
     * 删除菜单
     *
     * @param int|array $ids 菜单ID
     *
     * @return bool
     */
    public function destroyMenu($ids)
    {
        if (!is_array($ids)) {
            $ids = [intval($ids)];
        }
        $items = collect();
        foreach ($ids as $id) {
            $items->push($id);
            $items = $items->merge($this->getDescendants($id)->keys());
        }
        $items = $items->unique();
        if ($items->isEmpty()) {
            throw new ModelNotFoundException('菜单不存在');
        }

        DB::transaction(function () use ($items) {
            $this->destroy($items->toArray());
        });

        return true;
    }

    public static function boot()
    {
        parent::boot();

        static::observe(PermissionObserver::class);
    }
}
