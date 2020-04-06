<?php

namespace Chriscreates\Projects\Traits;

use Chriscreates\Projects\Models\Status;
use Illuminate\Database\Eloquent\Builder;

trait HasStatus
{
    /**
     * Check the status of the given model.
     *
     * @param  string|int|\Chriscreates\Projects\Models\Status $status
     * @return bool
     */
    public function hasStatus($status) : bool
    {
        if (is_null($this->status)) {
            return false;
        }

        if (is_int($status) || is_string($status)) {
            $status = Status::findByIdOrName($status);
        }

        if (is_null($status)) {
            return false;
        }

        if ($status instanceof Status) {
            $status = $status->id;
        }

        return $this->status_id === $status;
    }

    /**
     * Check if the given model has any status.
     *
     * @param  array                  $statuses
     * @return boolean
     */
    public function hasAnyStatus(array $statuses) : bool
    {
        return ! collect($statuses)->reject(function ($status, $key) {
            return ! $this->hasStatus($status);
        })->isEmpty();
    }

    /**
     * Set the status of the given model.
     *
     * @param  void                  $status
     */
    public function setStatus($status) : void
    {
        if (is_int($status) || is_string($status)) {
            $status = Status::findByIdOrName($status);
        }

        if (is_null($status)) {
            return;
        }

        $this->status()->save($status);
    }

    /**
     * Scope - return any model where status.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  string|int|\Chriscreates\Projects\Models\Status $status
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWhereHasStatus(Builder $query, $status)
    {
        $key = ! is_string($status) ? 'id' : 'name';

        $status = $status instanceof Status ? $status->id : $status;

        return $query->whereHas('status', function ($query) use ($key, $status) {
            return $query->where($key, $status);
        });
    }

    /**
     * Scope - return any model whereIn statuses.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  string                  $key
     * @param  array                   $statuses
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWhereHasAnyStatus(Builder $query, string $key, array $statuses)
    {
        return $query->whereHas('status', function ($query) use ($key, $statuses) {
            return $query->whereIn($key, $statuses);
        });
    }
}
