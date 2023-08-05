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
        'jabatan',
        'start_time',
        'finish_time',
        'status',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'start_time' => 'datetime',
        'finish_time' => 'datetime',
    ];

    /**
     * @var array
     */
    protected $appends = [
        'hour_difference',
        'normal_hours',
        'normal_hours_without_rest',
        'overtime',
        'first_hour_of_overtime',
        'second_hour_of_overtime',
        'third_hour_of_overtime',
        'fourth_hour_of_overtime',
        'more_than_four_hours_of_overtime',
        'total_overtime',
        'total_hours_worked',
        'um_normal',
        'um_lembur',
    ];

    public function getHourDifferenceAttribute()
    {
        $startTime = $this->carbonStartTime();
        $finishTime = $this->carbonFinishTime();

        return $finishTime->diffInHours($startTime);
    }

    public function getNormalHoursAttribute()
    {
        $startTime = $this->carbonStartTime();
        $finishTime = $this->carbonFinishTime();

        $currentDate = $startTime->format('Y-m-d');
        $oneOClockInTheAfternoon = Carbon::createFromFormat('Y-m-d H:i:s', $currentDate . ' 13:00:00');
        $fourOClockInTheAfternoon = Carbon::createFromFormat('Y-m-d H:i:s', $currentDate . ' 16:00:00');

        $jamSelesaiIstirahat = Carbon::createFromFormat('Y-m-d H:i:s', $currentDate . ' 13:00:00');
        $jamIstirahan = 1;

        $jamNormal = $this->status == "Sabtu" ? $oneOClockInTheAfternoon->diffInHours($startTime) :
            $fourOClockInTheAfternoon->diffInHours($startTime);

        if ($jamSelesaiIstirahat->isBetween($startTime, $finishTime)) {

            $jamNormal -= $jamIstirahan;
        }

        if ($this->status == "Libur") {

            return 0;
        }

        return  $jamNormal;
    }

    public function getNormalHoursWithoutRestAttribute()
    {
        $startTime = $this->carbonStartTime();
        $finishTime = $this->carbonFinishTime();

        $currentDate = $startTime->format('Y-m-d');
        $habisMagrib = Carbon::createFromFormat('Y-m-d H:i:s', $currentDate . ' 19:00:00');

        if ($this->status == "Libur") {

            if ($habisMagrib->isBetween($startTime, $finishTime)) {

                return $this->normal_hours + 1;
            }

            return $this->normal_hours;
        }

        return $this->normal_hours + 1;
    }

    public function getOvertimeAttribute()
    {
        $startTime = $this->carbonStartTime();
        $finishTime = $this->carbonFinishTime();

        $currentDate = $startTime->format('Y-m-d');

        $jamSelesaiIstirahat = Carbon::createFromFormat('Y-m-d H:i:s', $currentDate . ' 19:00:00');
        $jamIstirahat = 1;

        $jamNormalTanpaIstirahat = $this->normal_hours_without_rest;
        $jamLembur = $this->hour_difference - $jamNormalTanpaIstirahat;

        if ($jamSelesaiIstirahat->isBetween($startTime, $finishTime)) {

            $jamLembur -= $jamIstirahat;
        }

        return $jamLembur;
    }

    public function getFirstHourOfOvertimeAttribute()
    {
        $isLibur = $this->status == 'Libur';

        if ($isLibur && $this->overtime > 0) return 2;

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

    public function getUmNormalAttribute()
    {
        if ($this->status == "Libur") {

            return 1;
        }

        return $this->normal_hours > 0 ? 1 : 0;
    }

    public function getUmLemburAttribute()
    {
        return $this->overtime > 5 ? 1 : 0;
    }

    private function carbonStartTime()
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->start_time);
    }

    private function carbonFinishTime()
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->finish_time);
    }
}
