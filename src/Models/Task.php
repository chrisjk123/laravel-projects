<?php

namespace Chriscreates\Projects\Models;

use Chriscreates\Projects\Traits\HasPriority;
use Chriscreates\Projects\Traits\HasStatus;
use Chriscreates\Projects\Traits\IsMeasurable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Task extends Model
{
    use IsMeasurable, HasStatus, HasPriority;

    protected $table = 'tasks';

    public $primaryKey = 'id';

    public $guarded = ['id'];

    public $timestamps = true;

    protected $dates = [
        'started_at',
        'delivered_at',
        'expected_at',
    ];

    public function status() : HasOne
    {
        return $this->hasOne(Status::class, 'id', 'status_id');
    }

    public function priority() : HasOne
    {
        return $this->hasOne(Priority::class, 'id', 'priority_id');
    }

    public function projects() : MorphToMany
    {
        return $this->morphToMany(Project::class, 'projectable');
    }
}
