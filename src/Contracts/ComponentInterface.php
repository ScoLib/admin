<?php

namespace Sco\Admin\Contracts;

interface ComponentInterface extends WithModel
{
    /**
     * Configure Model class
     *
     * @return string
     */
    public function model();

    /**
     * Get name of the component
     *
     * @return string
     */
    public function getName();

    /**
     * Set name of the component
     *
     * @param string $value
     * @return $this
     */
    public function setName(string $value);

    /**
     * Get display name of the component
     *
     * @return string
     */
    public function getTitle();

    /**
     * Set display name of the component
     *
     * @param string $value
     * @return $this
     */
    public function setTitle(string $value);

    /**
     * @return mixed|\Sco\Admin\Contracts\RepositoryInterface
     */
    public function getRepository();

    /**
     * @param \Sco\Admin\Contracts\RepositoryInterface $repository
     * @return $this
     */
    public function setRepository(RepositoryInterface $repository);

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getConfigs();

    /**
     * @return null|\Sco\Admin\Contracts\Display\DisplayInterface
     */
    public function fireDisplay();

    public function get();

    /**
     * @return null|\Sco\Admin\Contracts\Form\FormInterface
     */
    public function fireCreate();

    /**
     * @return mixed
     */
    public function store();

    /**
     * @param $id
     *
     * @return null|\Sco\Admin\Contracts\Form\FormInterface
     */
    public function fireEdit($id);

    /**
     * @param mixed $id
     *
     * @return mixed
     */
    public function update($id);

    public function delete($id);

    public function forceDelete($id);

    public function restore($id);

    /**
     * @return \KodiComponents\Navigation\Contracts\NavigationInterface
     */
    public function getNavigation();

    /**
     * @param string|Closure|null $badge
     * @return \Sco\Admin\Navigation\Page
     */
    public function addToNavigation($badge = null);

    public function isDisplay();

    public function isCreate();

    public function isEdit();

    public function isDelete();

    public function isDestroy();

    public function isRestore();

    /**
     * Register an observer with the Component.
     *
     * @param $class
     */
    public function observe($class);

    /**
     * register ability to access.
     *
     * @param string $ability
     * @param string|\Closure $callback
     */
    public function registerAbility($ability, $callback);

    /**
     * Determine if the entity has a given ability.
     *
     * @param string $ability
     *
     * @return bool
     */
    public function can($ability);

    /**
     * Get all ability.
     *
     * @return Collection
     */
    public function getAccesses();
}
