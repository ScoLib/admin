<?php

namespace Sco\Admin\Form\Elements;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use InvalidArgumentException;
use Sco\Admin\Contracts\RepositoryInterface;

class Tree extends NamedElement
{
    protected $type = 'tree';

    protected $defaultValue = [];

    protected $rootNodeValue = '';

    protected $nodesModelParentAttribute = 'parent_id';

    protected $nodesModelLabelAttribute;

    protected $nodesModelValueAttribute;

    protected $nodes;

    public function __construct($name, $title, $nodes)
    {
        parent::__construct($name, $title);

        $this->setNodes($nodes);
    }

    public function getValue()
    {
        $value = $this->getValueFromModel();
        if (empty($value)) {
            return [];
        }

        if ($this->isNodesModel() && $this->isRelation()) {
            $model = $this->getNodesModel();
            $key   = $this->getNodesModelValueAttribute() ?: $model->getKeyName();

            return $value->pluck($key)->map(function ($item) {
                return (string)$item;
            });
        } else {
            return explode(',', $value);
        }
    }

    public function save()
    {
        if (!($this->isNodesModel() && $this->isRelation())) {
            parent::save();
        }
    }

    public function finishSave()
    {
        if (!($this->isNodesModel() && $this->isRelation())) {
            return;
        }
        $attribute = $this->getName();
        $values    = $this->getValueFromRequest();

        $relation = $this->getModel()->{$attribute}();
        if ($relation instanceof BelongsToMany) {
            $relation->sync($values);
        }
    }

    protected function isNodesModel()
    {
        return is_string($this->nodes) || $this->nodes instanceof Model;
    }

    protected function isRelation()
    {
        return method_exists($this->getModel(), $this->getName());
    }

    public function getNodes()
    {
        if ($this->nodes instanceof \Closure) {
            $nodes = ($this->nodes)();
        } elseif (is_string($this->nodes) || $this->nodes instanceof Model) {
            $nodes = $this->setNodesFromModel();
        } elseif (is_array($this->nodes)) {
            $nodes = $this->nodes;
        } else {
            throw new InvalidArgumentException(
                "The form tree element's nodes must be return array"
            );
        }

        return $nodes;
    }

    /**
     * @param $nodes
     * @param $parentId
     *
     * @return \Illuminate\Support\Collection
     */
    public function getNodesTree($nodes, $parentId)
    {
        return collect($nodes)->filter(function ($value) use ($parentId) {
            if (isset($value['parent_id'])) {
                if ($value['parent_id'] == $parentId) {
                    return true;
                }
                return false;
            }
            return true;
        })->mapWithKeys(function ($value, $key) use ($nodes) {
            $data = [
                'id'    => (string)$value['id'],
                'label' => $value['label'],
            ];

            if (isset($value['parent_id'])) {
                $children = $this->getNodesTree($nodes, $value['id']);
                if ($children->isNotEmpty()) {
                    $data['children'] = $children;
                }
            }

            return [
                $key => $data,
            ];
        })->values();
    }

    public function setNodes($nodes)
    {
        $this->nodes = $nodes;

        return $this;
    }

    /**
     * @return array
     */
    protected function setNodesFromModel()
    {
        if (is_null($this->getNodesModelLabelAttribute())) {
            throw new InvalidArgumentException(
                sprintf(
                    "Form %s element's nodes must be set model label attribute",
                    $this->getType()
                )
            );
        }

        $model = $this->getNodesModel();

        $repository = app(RepositoryInterface::class);
        $repository->setModel($model);

        $results = $repository->getQuery()->get();

        $key = $this->getNodesModelValueAttribute() ?: $model->getKeyName();

        return $results->mapWithKeys(function ($item, $ikey) use ($key) {
            $data = [
                'id'    => $item[$key],
                'label' => $item[$this->getNodesModelLabelAttribute()],
            ];
            if (isset($item[$this->getNodesModelParentAttribute()])) {
                $data['parent_id'] = $item[$this->getNodesModelParentAttribute()];
            }

            return [
                $ikey => $data,
            ];
        });
    }

    /**
     * @return Model
     */
    protected function getNodesModel()
    {
        $model = $this->nodes;

        if (is_string($model)) {
            $model = app($model);
        }

        if (!($model instanceof Model)) {
            throw new InvalidArgumentException(
                sprintf(
                    "Form tree element's nodes class must be instanced of '%s'.",
                    Model::class
                )
            );
        }

        return $model;
    }

    public function getNodesModelLabelAttribute()
    {
        return $this->nodesModelLabelAttribute;
    }

    public function setNodesModelLabelAttribute($value)
    {
        $this->nodesModelLabelAttribute = $value;

        return $this;
    }

    public function getNodesModelValueAttribute()
    {
        return $this->nodesModelValueAttribute;
    }

    public function setNodesModelValueAttribute($value)
    {
        $this->nodesModelValueAttribute = $value;

        return $this;
    }

    public function getNodesModelParentAttribute()
    {
        return $this->nodesModelParentAttribute;
    }

    public function setNodesModelParentAttribute($value)
    {
        $this->nodesModelParentAttribute = $value;

        return $this;
    }

    public function getRootNodeValue()
    {
        return $this->rootNodeValue;
    }

    public function setRootNodeValue($value)
    {
        $this->rootNodeValue = $value;

        return $this;
    }

    public function toArray()
    {
        return parent::toArray() + [
                'nodes' => $this->getNodesTree(
                    $this->getNodes(),
                    $this->getRootNodeValue()
                ),
            ];
    }
}
