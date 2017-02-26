<?php

namespace Sco\Admin\Models;

use Cache;
use Sco\Tree\Traits\TreeTrait;
use Zizaco\Entrust\EntrustPermission;

class Permission extends EntrustPermission
{
    use TreeTrait;

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

        $this->allRoutes = Cache::rememberForever('permission_all', function () {
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
        $self   = $this->getInfoByName($name);
        if ($self) {
            $parent = $this->getParentTree($self->id);
            $parent->push($self);
            return $parent;
        }
        return false;

    }

    public function saveMenu(Request $request, $id = 0)
    {
        $input = $request->input();
        $this->updateOrCreate(['id' => $id], $input);
        return true;
    }

}
