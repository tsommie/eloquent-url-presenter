<?php

namespace AcDevelopers\EloquentUrlPresenter;

use Illuminate\Database\Eloquent\Model;

/**
 * Class EloquentUrlPresenter
 *
 * @package AcDevelopers\EloquentUrlPresenter
 */
class EloquentUrlPresenter
{
    /**
     * @var Model $entity
     */
    protected $entity;

    /**
     * EloquentUrlPresenter constructor.
     *
     * @param \Illuminate\Database\Eloquent\Model $entity
     */
    public function __construct(Model $entity)
    {
        $this->entity = $entity;
    }

    /**
     * is utilized for reading data from inaccessible members.
     *
     * @param $key string
     * @return mixed
     * @link http://php.net/manual/en/language.oop5.overloading.php#language.oop5.overloading.members
     */
    function __get($key)
    {
        if(method_exists($this, $key))
        {
            return $this->{$key}();
        }

        return $this->$key;
    }
}