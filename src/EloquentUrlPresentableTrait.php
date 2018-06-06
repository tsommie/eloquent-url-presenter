<?php

namespace AcDevelopers\EloquentUrlPresenter;
use AcDevelopers\EloquentUrlPresenter\Exception\EloquentUrlPresenterException;

/**
 * Class EloquentUrlPresentableTrait
 *
 * @package AcDevelopers\EloquentUrlPresenter
 */
trait EloquentUrlPresentableTrait
{
    /**
     * View presenter instance
     *
     * @var mixed
     */
    protected $presenterInstance;

    /**
     * Prepare a new or cached url presenter instance
     *
     * @return mixed
     */
    abstract public function urlPresenter();

    /**
     * Prepare a new or cached presenter instance
     *
     * @return mixed
     * @throws EloquentUrlPresenterException
     */
    public function getUrlAttribute()
    {
        if ( ! $this->urlPresenter() or ! class_exists($this->urlPresenter()))
        {
            throw new EloquentUrlPresenterException('Please set the urlPresenter method to your url presenter path.');
        }

        if ( ! $this->presenterInstance)
        {
            $urlPresenter = $this->urlPresenter();

            $this->presenterInstance = new $urlPresenter($this);
        }

        return $this->presenterInstance;
    }
}