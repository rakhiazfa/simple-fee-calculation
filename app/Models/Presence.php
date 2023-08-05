<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Presence extends Model
{
    use HasFactory;

    /**
     * @var array
     */
    protected $fillable = [
        'employee_name',
        'date',
        'start_time',
        'finish_time',
        'is_holiday',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'is_holiday' => 'boolean',
    ];

    /**
     * @var array
     */
    protected $appends = [
        'hour_difference',
        'normal_hours',
        'overtime',
        'first_hour_of_overtime',
        'second_hour_of_overtime',
        'third_hour_of_overtime',
        'fourth_hour_of_overtime',
        'more_than_four_hours_of_overtime',
        'total_overtime',
        'total_hours_worked',
    ];

    public function getHourDifferenceAttribute()
    {
        $startTime = Carbon::createFromFormat('H:i:s', $this->start_time);
        $finishTime = Carbon::createFromFormat('H:i:s', $this->finish_time);

        return $finishTime->diffInHours($startTime);
    }

    public function getNormalHoursAttribute()
    {
        $startTime = Carbon::createFromFormat('H:i:s', $this->start_time);
        $fourOClockInTheAfternoon = Carbon::createFromFormat('H:i:s', '16:00:00');

        return $fourOClockInTheAfternoon->diffInHours($startTime);
    }

    public function getOvertimeAttribute()
    {
        return $this->hour_difference - $this->normal_hours;
    }

    public function getFirstHourOfOvertimeAttribute()
    {
        if ($this->is_holiday && $this->overtime > 0) return 2;

        if ($this->overtime > 0) return 1.5;

        return 0;
    }

    public function getSecondHourOfOvertimeAttribute()
    {
        if ($this->overtime > 1) return 2;

        return 0;
    }

    public function getThirdHourOfOvertimeAttribute()
    {
        if ($this->overtime > 2) return 2;

        return 0;
    }

    public function getFourthHourOfOvertimeAttribute()
    {
        if ($this->overtime > 3) return 2;

        return 0;
    }

    public function getMoreThanFourHoursOfOvertimeAttribute()
    {
        if ($this->overtime > 4) return ($this->overtime - 4) * 2;

        return 0;
    }

    public function getTotalOvertimeAttribute()
    {
        return $this->first_hour_of_overtime +
            $this->second_hour_of_overtime +
            $this->third_hour_of_overtime +
            $this->fourth_hour_of_overtime +
            $this->more_than_four_hours_of_overtime;
    }

    public function getTotalHoursWorkedAttribute()
    {
        return $this->normal_hours + $this->total_overtime;
    }
}
