<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['name', 'schedule'];

    protected $appends = ['scheduled_today', 'completed_today', 'completed_today_by'];

    public function completions()
    {
        return $this->hasMany(Completion::class);
    }

    public function complete()
    {
        return $this->completions()->create([
            'user_id' => auth()->id()
        ]);
    }

    public function scheduledToday()
    {
        return resolve(Weekday::class)->scheduledToday($this->schedule);
    }

    public function completedToday()
    {
        return $this->completions()->whereDate('created_at', Carbon::today())->exists();
    }

    public function getScheduledTodayAttribute()
    {
        return $this->scheduledToday();
    }

    public function getCompletedTodayAttribute()
    {
        return $this->completedToday();
    }

    public function getCompletedTodayByAttribute()
    {
        if ($completion = $this->completions()->whereDate('created_at', Carbon::today())->first()) {
            return $completion->user->name;
        }

        return null;
    }
}
