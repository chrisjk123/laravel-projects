<?php

namespace Chriscreates\Projects\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Status extends Model
{
    protected $table = 'statuses';

    public $primaryKey = 'id';

    public $guarded = ['id'];

    public $timestamps = true;

    public function tasks() : HasMany
    {
        return $this->hasMany(Task::class, 'status_id', 'id');
    }

    public function projects() : HasMany
    {
        return $this->hasMany(Project::class, 'status_id', 'id');
    }

    public static function findByIdOrName($value)
    {
        return static::query()
        ->where('id', $value)
        ->orWhere('name', $value)
        ->first();
    }
}
