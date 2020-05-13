<?php

namespace Chriscreates\Projects\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Comment extends Model
{
    protected $table = 'comments';

    public $primaryKey = 'id';

    public $guarded = ['id'];

    public $timestamps = true;

    public function commentable() : MorphTo
    {
        return $this->morphTo();
    }
}
