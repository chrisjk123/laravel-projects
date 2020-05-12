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
        'deduct_hours' => 'integer',
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

    public function recordTime($from, $to) : void
    {
        $this->records()->create([
            'time_from' => $from,
            'time_to' => $to,
        ]);

        $this->refresh();
    }

    public function removeRecord(Record $record) : void
    {
        if ($record = $this->records->firstWhere('id', $record->id)) {
            $record->delete();
        }

        $this->refresh();
    }

    public function deductHours($time) : void
    {
        $this->records()->create([
            'deduct_hours' => (float) $time,
            'deductable' => true,
        ]);

        $this->refresh();
    }

    public function addHours($time) : void
    {
        $record = $this->records()->create([
            'add_hours' => (float) $time,
            'deductable' => false,
        ]);

        $this->refresh();
    }
}
