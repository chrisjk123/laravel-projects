<?php

namespace Chriscreates\Projects\Models;

use Chriscreates\Projects\Collections\RecordsCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Record extends Model
{
    protected $table = 'records';

    public $primaryKey = 'id';

    public $guarded = ['id'];

    public $timestamps = true;

    protected $dates = [
        'time_from',
        'time_to',
    ];

    public function recordable() : MorphTo
    {
        return $this->morphTo();
    }

    public function getDeductableHours()
    {
        if ( ! $this->deductable && ! $this->deduct_hours) {
            return 0;
        }

        return $this->deduct_hours;
    }

    public function getRecordableHours()
    {
        if ($this->add_hours && ! $this->deductable) {
            return $this->add_hours;
        }

        if ( ! $this->time_from || ! $this->time_to) {
            return 0;
        }

        return $this->time_from->floatDiffInRealHours($this->time_to, false);
    }

    /**
     * Create a new Eloquent Collection instance.
     *
     * @param  array  $models
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function newCollection(array $models = [])
    {
        return new RecordsCollection($models);
    }
}
