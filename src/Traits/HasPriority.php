<?php

namespace Chriscreates\Projects\Traits;

use Chriscreates\Projects\Models\Priority;

trait HasPriority
{
    /**
     * Check the priority of the given model.
     *
     * @param  string|int|\Chriscreates\Projects\Models\Priority $priority
     * @return bool
     */
    public function hasPriority($priority) : bool
    {
        if (is_null($this->priority)) {
            return false;
        }

        if (is_int($priority) || is_string($priority)) {
            $priority = Priority::findByIdOrName($priority);
        }

        if (is_null($priority)) {
            return false;
        }

        if ($priority instanceof Priority) {
            $priority = $priority->id;
        }

        return $this->priority_id === $priority;
    }

    /**
     * Check if the given model has any priority.
     *
     * @param  array                  $priorities
     * @return boolean
     */
    public function hasAnyPriority(array $priorities) : bool
    {
        return ! collect($priorities)->reject(function ($priority, $key) {
            return ! $this->hasPriority($priority);
        })->isEmpty();
    }

    /**
     * Set the priority of the given model.
     *
     * @param  void                  $priority
     */
    public function setPriority($priority) : void
    {
        if (is_int($priority) || is_string($priority)) {
            $priority = Priority::findByIdOrName($priority);
        }

        if (is_null($priority)) {
            return;
        }

        $this->priority()->save($priority);
    }
}
