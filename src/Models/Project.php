<?php

namespace Chriscreates\Projects\Models;

use BadMethodCallException;
use Carbon\Carbon;
use Chriscreates\Projects\Traits\HasStatus;
use Chriscreates\Projects\Traits\HasUsers;
use Chriscreates\Projects\Traits\IsMeasurable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Project extends Model
{
    use IsMeasurable, HasUsers, HasStatus;

    protected $table = 'projects';

    public $primaryKey = 'id';

    public $guarded = ['id'];

    public $timestamps = true;

    private $user_model;

    protected $dates = [
        'started_at',
        'delivered_at',
        'expected_at',
    ];

    protected $casts = [
        'visible' => 'boolean',
    ];

    public function __construct(array $attributes = [])
    {
        $this->user_model = config('projects.user_class');

        parent::__construct($attributes);
    }

    public function owner() : BelongsTo
    {
        return $this->belongsTo(get_class(user_model()));
    }

    public function status() : BelongsTo
    {
        return $this->belongsTo(Status::class);
    }

    public function tasks() : MorphToMany
    {
        return $this->morphedByMany(Task::class, 'projectable');
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
}
