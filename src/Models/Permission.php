<?php

namespace Sco\Admin\Models;

use DB;
use Cache;
use Illuminate\Http\Request;
use Sco\Admin\Exceptions\AdminHttpException;
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

    protected $hidden = ['created_at', 'updated_at'];

    protected $guarded = ['created_at', 'updated_at'];

    protected $treeNodeParentIdName = 'pid';

    private $allRoutes = null;

    private $validList = null;

    private $permList = null;

    private $menuList = null;


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

        $this->allRoutes = Cache::rememberForever('permission_all',
            function () {
                return $this->orderBy('sort')->get();
            });
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
     * 获取有效的路由列表
     *
     * @return \Illuminate\Support\Collection
     */
    public function getValidRouteList()
    {
        if ($this->validList) {
            return $this->validList;
        }

        $all = $this->getAll();

        $this->validList = collect([]);
        foreach ($all as $route) {
            if (!empty($route->uri) && $route->uri != '#') {
                $this->validList->push($route);
            }
        }
        return $this->validList;
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

    public function getInfoById($id)
    {
        return $this->getSelf($id);
    }

    public function getInfoByName($name)
    {
        $all = $this->getAll();
        $key = $all->search(function ($item) use ($name) {
            return $item->name == $name;
        });
        return $key === false ? false : $all->get($key);
    }

    public function getParentTree($id)
    {
        return $this->getAncestors($id);
    }

    public function getParentTreeAndSelfById($id)
    {
        $self = $this->getInfoById($id);
        if ($self) {
            $parent = $this->getParentTree($self->id);
            $parent->push($self);
            return $parent;
        }
        return false;
    }

    public function getParentTreeAndSelfByName($name)
    {
        $self = $this->getInfoByName($name);
        if ($self) {
            $parent = $this->getParentTree($self->id);
            $parent->push($self);
            return $parent;
        }
        return false;
    }

    public function saveMenu(Request $request)
    {
        if (empty($request->input('id'))) {
            $model = $this;
        } else {
            $model = $this->findOrFail($request->input('id'));
        }

        $model->pid          = $request->input('pid');
        $model->display_name = $request->input('display_name');
        $model->name         = $request->input('name');
        $model->icon         = $request->input('icon') ?: '';
        $model->is_menu      = $request->input('is_menu', 0);
        $model->sort         = $request->input('sort', 255);
        $model->description  = $request->input('description') ?: '';

        $model->save();

        $this->clearCache();
        return true;
    }

    public function deleteMenu($id)
    {
        $info = $this->getInfoById($id);
        if (is_null($info)) {
            throw new AdminHttpException('菜单不存在');
        }

        $childs = $this->getDescendants($id)->keys();
        $childs->push($id);
        DB::transaction(function () use ($childs) {
            $this->destroy($childs->toArray());
        });

        $this->clearCache();

        return true;
    }

    private function clearCache()
    {
        Cache::forget('permission_all');
    }
}
