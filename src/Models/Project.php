<?php

namespace Chriscreates\Projects\Models;

use BadMethodCallException;
use Carbon\Carbon;
use Chriscreates\Projects\Traits\HasStatus;
use Chriscreates\Projects\Traits\HasUsers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\morphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Project extends Model
{
    use HasUsers, HasStatus;

    protected $table = 'projects';

    public $primaryKey = 'id';

    public $guarded = ['id'];

    public $timestamps = true;

    protected $dates = [
        'started_at',
        'delivered_at',
        'expected_at',
    ];

    protected $casts = [
        'visible' => 'bool',
    ];

    public function author() : BelongsTo
    {
        return $this->belongsTo(get_class(user_model()), 'author_id');
    }

    public function owner() : BelongsTo
    {
        return $this->belongsTo(get_class(user_model()), 'owner_id');
    }

    public function status() : BelongsTo
    {
        return $this->belongsTo(Status::class);
    }

    public function tasks() : MorphToMany
    {
        return $this->morphedByMany(Task::class, 'projectable');
    }

    public function comments() : MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function isVisible() : bool
    {
        return $this->attributes['visible'] == true;
    }

    public function isNotVisible() : bool
    {
        return $this->attributes['visible'] == false;
    }

    public function dueIn(string $format = 'days') : int
    {
        $method = 'diffIn'.ucfirst($format);

        if ( ! $this->hasDateTarget()) {
            return 0;
        }

        if ( ! method_exists(Carbon::class, $method)) {
            throw new BadMethodCallException(sprintf(
                'Method %s::%s does not exist.',
                Carbon::class,
                $method
            ));
        }

        return $this->started_at->$method($this->expected_at);
    }

    public function assignTask(Task $task) : void
    {
        $this->tasks()->save($task);
    }

    public function removeTask(Task $task) : void
    {
        $this->tasks()->detach($task);
    }

    public function hasTask(Task $task) : bool
    {
        return $this->tasks->contains($task->id);
    }

    /**
     * Has the task got an expected target.
     *
     * @return bool
     */
    public function hasDateTarget() : bool
    {
        return $this->attributes['started_at'] || $this->attributes['expected_at'];
    }

    /**
     * Is the task still in process.
     *
     * @return bool
     */
    public function isInProcess() : bool
    {
        return is_null($this->attributes['delivered_at']);
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

        return ($this->completedOnSchedule() || $this->completedAfterSchedule())
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
