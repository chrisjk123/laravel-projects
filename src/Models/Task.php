<?php

namespace Chriscreates\Projects\Models;

use Chriscreates\Projects\Traits\HasPriority;
use Chriscreates\Projects\Traits\IsRecordable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Task extends Model
{
    use IsRecordable, HasPriority;

    protected $table = 'tasks';

    public $primaryKey = 'id';

    public $guarded = ['id'];

    public $timestamps = true;

    protected $casts = [
        'complete' => 'bool',
    ];

    public function creator() : BelongsTo
    {
        return $this->belongsTo(get_class(user_model()));
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

    public function assignToProject(Project $project) : void
    {
        $this->projects()->save($project);

        $this->refresh();
    }

    public function markCompletion(bool $bool) : void
    {
        $this->update(['complete' => $bool]);
    }

    public function completed() : bool
    {
        return $this->attributes['complete'];
    }
}
