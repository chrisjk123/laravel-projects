<?php

namespace Chriscreates\Projects\Models;

use Chriscreates\Projects\Traits\HasPriority;
use Chriscreates\Projects\Traits\HasStatus;
use Chriscreates\Projects\Traits\IsMeasurable;
use Chriscreates\Projects\Traits\IsRecordable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Task extends Model
{
    use IsMeasurable, IsRecordable, HasStatus, HasPriority;

    protected $table = 'tasks';

    public $primaryKey = 'id';

    public $guarded = ['id'];

    public $timestamps = true;

    protected $dates = [
        'started_at',
        'delivered_at',
        'expected_at',
    ];

    public function creator() : BelongsTo
    {
        return $this->belongsTo(get_class(user_model()));
    }

    public function status() : BelongsTo
    {
        return $this->belongsTo(Status::class);
    }

    public function priority() : BelongsTo
    {
        return $this->belongsTo(Priority::class);
    }

    public function projects() : MorphToMany
    {
        return $this->morphToMany(Project::class, 'projectable');
    }

    public function records() : MorphMany
    {
        return $this->morphMany(Record::class, 'recordable');
    }
}
