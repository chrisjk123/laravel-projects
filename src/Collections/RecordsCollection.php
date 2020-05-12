<?php

namespace Chriscreates\Projects\Collections;

use Illuminate\Database\Eloquent\Collection;

class RecordsCollection extends Collection
{
    public function sumHours()
    {
        return $this->sum->getRecordableHours() - $this->sum->getDeductableHours();
    }
}
