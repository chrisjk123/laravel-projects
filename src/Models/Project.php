<?php

namespace Chriscreates\Projects\Models;

use BadMethodCallException;
use Carbon\Carbon;
use Chriscreates\Projects\Traits\HasUsers;
use Chriscreates\Projects\Traits\IsMeasurable;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use IsMeasurable, HasUsers;

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

    public function __construct(array $attributes = [])
    {
        $this->user_model = config('projects.user_class');

        parent::__construct($attributes);
    }

    public function isVisible() : bool
    {
        return $this->visible;
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
