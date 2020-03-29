<?php

namespace Chriscreates\Projects\Traits;

trait IsMeasurable
{
    /**
     * Has the project got an expected target.
     *
     * @return bool
     */
    public function hasDateTarget() : bool
    {
        return $this->started_at !== null || $this->expected_at !== null;
    }

    /**
     * Is the project complete.
     *
     * @return bool
     */
    public function isComplete() : bool
    {
        if ( ! $this->hasDateTarget()) {
            return false;
        }

        if ($this->isInProcess()) {
            return false;
        }

        return $this->completedOnSchedule() || $this->completedAfterDeadline();
    }

    /**
     * Was the project completed after the given deadline.
     *
     * @return bool
     */
    public function completedAfterDeadline() : bool
    {
        return $this->delivered_at->greaterThan($this->expected_at);
    }

    /**
     * Was the project completed before the given deadline.
     *
     * @return bool
     */
    public function completedBeforeDeadline() : bool
    {
        return $this->delivered_at->lessThan($this->expected_at);
    }

    /**
     * Was the project completed before or on the given deadline.
     *
     * @return bool
     */
    public function completedOnSchedule() : bool
    {
        return $this->completedBeforeDeadline() || $this->delivered_at->equalTo($this->expected_at);
    }

    /**
     * Is the project still in process.
     *
     * @return bool
     */
    public function isInProcess() : bool
    {
        return $this->delivered_at === null;
    }

    /**
     * Is the project overdue.
     *
     * @return bool
     */
    public function isOverdue() : bool
    {
        return $this->isInProcess() && $this->notDueYet();
    }

    /**
     * Is the project not due yet.
     *
     * @return bool
     */
    public function notDueYet()
    {
        return $this->expected_at->lessThan(now());
    }
}
