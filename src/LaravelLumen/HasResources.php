<?php

namespace AcDevelopers\EloquentUrlPresenter\LaravelLumen;

/**
 * Class HasResources
 *
 * @package AcDevelopers\EloquentUrlPresenter\LaravelLumen
 */
trait HasResources
{
    /**
     * Get the delete url for this entity
     *
     * @return string
     */
    public function delete()
    {
        return route($this->route().'.destroy', $this->parameters());
    }

    /**
     * Get the edit url for this entity
     *
     * @return string
     */
    public function edit()
    {
        return route($this->route().'.edit', $this->parameters());
    }

    /**
     * Get the show url for this entity
     *
     * @return string
     */
    public function show()
    {
        return route($this->route().'.show', $this->parameters());
    }

    /**
     * Get the update url for this entity
     *
     * @return string
     */
    public function update()
    {
        return route($this->route().'.update', $this->parameters());
    }

    /**
     * @return array
     */
    abstract protected function parameters();

    /**
     * Return the resource name as provided in the web.php/route file.
     * This should be the first argument provided in the
     * Route::resource method.
     *
     * @return string
     */
    abstract protected function route();
}