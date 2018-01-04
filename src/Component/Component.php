<?php

namespace Sco\Admin\Component;

use BadMethodCallException;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;
use Illuminate\Foundation\Application;
use Sco\Admin\Component\Concerns\HasAccess;
use Sco\Admin\Component\Concerns\HasEvents;
use Sco\Admin\Component\Concerns\HasNavigation;
use Sco\Admin\Contracts\ComponentInterface;
use Sco\Admin\Contracts\Form\FormInterface;
use Sco\Admin\Contracts\RepositoryInterface;
use Sco\Admin\Contracts\Display\DisplayInterface;
use Sco\Admin\Contracts\WithNavigation;

abstract class Component implements ComponentInterface, WithNavigation
{
    use HasAccess, HasEvents, HasNavigation;

    /**
     * @var
     */
    protected $name;

    /**
     * @var \Illuminate\Foundation\Application
     */
    protected $app;

    /**
     * The component display name
     *
     * @var string
     */
    protected $title;

    /**
     * @var mixed|\Sco\Admin\Contracts\RepositoryInterface
     */
    protected $repository;

    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;

    protected static $booted = [];

    /**
     * @var \Illuminate\Contracts\Events\Dispatcher
     */
    protected static $dispatcher;

    abstract public function model();

    public function __construct(Application $app, RepositoryInterface $repository)
    {
        $this->app = $app;

        $this->makeModel();

        $this->repository = $repository;
        $this->repository->setModel($this->getModel());

        if (! $this->name) {
            $this->setDefaultName();
        }

        $this->bootIfNotBooted();
    }

    protected function setDefaultName()
    {
        $this->name = $this->getModelClassName();
    }

    /**
     * @return string
     */
    protected function getModelClassName()
    {
        return snake_case( // 蛇形命名
            str_plural( // 复数
                class_basename(
                    get_class($this->getModel())
                )
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Model|mixed
     */
    protected function makeModel()
    {
        $class = $this->model();
        if (empty($class)) {
            throw new InvalidArgumentException(
                sprintf(
                    'The component(%s) method "model()" not found value',
                    get_class($this)
                )
            );
        }

        $model = $this->app->make($this->model());

        if (! ($model instanceof Model)) {
            throw new InvalidArgumentException(
                sprintf(
                    "Class %s must be an instance of %s",
                    $this->model(),
                    Model::class
                )
            );
        }

        return $this->model = $model;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * {@inheritdoc}
     */
    public function getRepository()
    {
        return $this->repository;
    }

    /**
     * {@inheritdoc}
     */
    public function getConfigs()
    {
        return collect([
            'title'    => $this->getTitle(),
            'accesses' => $this->getAccesses(),
            'display'  => $this->fireDisplay(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    final public function fireDisplay()
    {
        if (! method_exists($this, 'callDisplay')) {
            throw new BadMethodCallException('Not Found Method "callDisplay"');
        }

        $display = $this->app->call([$this, 'callDisplay']);

        if (! $display instanceof DisplayInterface) {
            throw new InvalidArgumentException(
                sprintf(
                    'callDisplay must be instanced of "%s".',
                    DisplayInterface::class
                )
            );
        }

        $display->setModel($this->getModel());
        $display->initialize();

        return $display;
    }

    public function get()
    {
        $display = $this->fireDisplay();

        return $display->get();
    }

    /**
     * {@inheritdoc}
     */
    final public function fireCreate()
    {
        if (! method_exists($this, 'callCreate')) {
            return;
        }

        $form = $this->app->call([$this, 'callCreate']);
        if (! $form instanceof FormInterface) {
            throw new InvalidArgumentException(
                sprintf(
                    'callCreate must be instanced of "%s".',
                    FormInterface::class
                )
            );
        }

        $form->setModel($this->getModel());

        return $form;
    }

    /**
     * {@inheritdoc}
     */
    public function store()
    {
        $form = $this->fireCreate();

        $form->validate()->save();
    }

    /**
     * {@inheritdoc}
     */
    final public function fireEdit($id)
    {
        if (! method_exists($this, 'callEdit')) {
            return;
        }

        $form = $this->app->call([$this, 'callEdit'], ['id' => $id]);

        if (! $form instanceof FormInterface) {
            throw new InvalidArgumentException(
                sprintf(
                    'callEdit must be instanced of "%s".',
                    FormInterface::class
                )
            );
        }

        $model = $this->getRepository()->findOrFail($id);

        $form->setModel($model);

        return $form;
    }

    /**
     * {@inheritdoc}
     */
    public function update($id)
    {
        $form = $this->fireEdit($id);
        $form->validate()->save();
    }

    public function delete($id)
    {
        $this->getRepository()->delete($id);

        return true;
    }

    public function forceDelete($id)
    {
        $this->getRepository()->forceDelete($id);

        return true;
    }

    public function restore($id)
    {
        $this->getRepository()->restore($id);

        return true;
    }

    protected function bootIfNotBooted()
    {
        if (! isset(static::$booted[static::class])) {
            static::$booted[static::class] = true;

            $this->fireEvent('booting', false);

            $this->boot();

            $this->fireEvent('booted', false);
        }
    }

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected function boot()
    {
        $this->bootTraits();
    }

    /**
     * Boot all of the bootable traits on the model.
     *
     * @return void
     */
    protected function bootTraits()
    {
        foreach (class_uses_recursive($this) as $trait) {
            if (method_exists($this, $method = 'boot' . class_basename($trait))) {
                $this->$method();
            }
        }
    }
}
