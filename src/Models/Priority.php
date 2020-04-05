<?php

namespace Chriscreates\Projects\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Priority extends Model
{
    protected $table = 'priorities';

    public $primaryKey = 'id';

    public $guarded = ['id'];

    public $timestamps = true;

    public function tasks() : HasMany
    {
        return $this->hasMany(Task::class, 'priority_id', 'id');
    }

    public static function findByIdOrName($value)
    {
        return static::query()
        ->where('id', $value)
        ->orWhere('name', $value)
        ->first();
    }
}
