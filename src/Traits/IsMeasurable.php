<?php

namespace Chriscreates\Projects\Traits;

trait IsMeasurable
{
    /**
     * Has the task got an expected target.
     *
     * @return bool
     */
    public function hasDateTarget() : bool
    {
        return $this->started_at !== null || $this->expected_at !== null;
    }

    /**
     * Is the task still in process.
     *
     * @return bool
     */
    public function isInProcess() : bool
    {
        return $this->delivered_at === null;
    }

    /**
     * Is the task not due yet.
     *
     * @return bool
     */
    public function notDueYet() : bool
    {
        return $this->expected_at->greaterThan(now());
    }

    /**
     * Is the task complete.
     *
     * @return bool
     */
    public function completed() : bool
    {
        if ( ! $this->hasDateTarget() || $this->isInProcess()) {
            return false;
        }

        return ($this->completedOnSchedule()
        || $this->completedAfterSchedule())
        && $this->completedAllTasks();
    }

    /**
     * Was the task completed after the given deadline.
     *
     * @return bool
     */
    public function completedAfterSchedule() : bool
    {
        return $this->delivered_at->greaterThan($this->expected_at);
    }

    /**
     * Was the task completed before the given deadline.
     *
     * @return bool
     */
    public function completedBeforeSchedule() : bool
    {
        return $this->delivered_at->lessThan($this->expected_at);
    }

    /**
     * Was the task completed before or on the given deadline.
     *
     * @return bool
     */
    public function completedOnSchedule() : bool
    {
        return $this->delivered_at->lessThanOrEqualTo($this->expected_at);
    }

    /**
     * Is the task overdue.
     *
     * @return bool
     */
    public function isOverdue() : bool
    {
        return $this->isInProcess() && ! $this->notDueYet();
    }

    /**
     * Have all tasks been completed.
     *
     * @return bool
     */
    public function completedAllTasks() : bool
    {
        $this->load('tasks');

        if ($this->tasks->isEmpty()) {
            return true;
        }

        return $this->tasks->count() === $this->tasks->sum->completed();
    }
}
