<?php

namespace Chriscreates\Projects\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\DB;

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

    protected $appends = [
        'hours',
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        parent::boot();

        static::addGlobalScope('hours', function (Builder $builder) {
            $builder->select('*');
            $builder->addSelect(
                DB::raw('ROUND(TIMESTAMPDIFF(MINUTE, `time_from`, `time_to`)/60, 2) as `hours`')
            );
        });
    }

    public function recordable() : MorphTo
    {
        return $this->morphTo();
    }

    public function getHoursAttribute() : float
    {
        if (is_null($this->time_from) || is_null($this->time_to)) {
            return 0;
        }

        $hours = $this->time_from->floatDiffInRealHours($this->time_to, false);

        return $hours;
    }

    public function hours($rounded_up = false)
    {
        if ( ! isset($this->attributes['hours']) || empty($this->attributes['hours'])) {
            return 0;
        }

        if ($rounded_up) {
            return round($this->attributes['hours'] * 2) / 2;
        }

        return $this->attributes['hours'];
    }
}
