<?php

namespace Chriscreates\Projects\Traits;

trait IsRecordable
{
    public function totalHours($rounded_up = false)
    {
        return $this->records->map->hours($rounded_up)->sum();
    }
}
