<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Weekday extends Model
{
    public function today()
    {
        return 1 << Carbon::now()->dayOfWeek;
    }

    public function anotherDay()
    {
        if (Carbon::now()->dayOfWeek === 0) {
            return 1 << 6;
        }

        return 1 << 1;
    }

    public function scheduledToday($schedule)
    {
        return ($schedule & $this->today()) > 0;
    }
}
