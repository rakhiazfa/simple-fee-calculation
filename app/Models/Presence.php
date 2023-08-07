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

        $istirahatPertama = $this->carbonIstirahatPertama();
        $jamIstirahan = 1;

        if ($this->status == "Sabtu") {

            if ($this->diantaraJamPulangSabtu()) {

                $jamNormal = $oneOClockInTheAfternoon->diffInHours($startTime);
            } else {

                $jamNormal = $finishTime->diffInHours($startTime);
            }
        }

        if ($this->status == "Normal") {

            if ($this->diantaraJamPulangNormal()) {

                $jamNormal = $fourOClockInTheAfternoon->diffInHours($startTime);
            } else {

                $jamNormal = $finishTime->diffInHours($startTime);
            }
        }

        if ($this->status == "Libur") {

            return 0;
        }

        if ($istirahatPertama->isBetween($startTime, $finishTime)) {

            $jamNormal -= $jamIstirahan;
        }

        return  $jamNormal;
    }

    public function getNormalHoursWithoutRestAttribute()
    {
        $startTime = $this->carbonStartTime();
        $finishTime = $this->carbonFinishTime();

        $istirahatPertama = $this->carbonIstirahatPertama();

        if ($this->status == "Libur") {

            if ($istirahatPertama->isBetween($startTime, $finishTime)) {

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

        $istirahatKedua = $this->carbonIstirahatKedua();
        $jamIstirahat = 1;

        $jamNormalTanpaIstirahat = $this->normal_hours_without_rest;
        $jamLembur = $this->hour_difference - $jamNormalTanpaIstirahat;

        if ($istirahatKedua->isBetween($startTime, $finishTime)) {

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
        return 1;
    }

    public function getUmLemburAttribute()
    {
        $startTime = $this->carbonStartTime();
        $finishTime = $this->carbonFinishTime();

        $jamSepuluhMalam = $this->carbonJamSepuluhMalam();

        return $jamSepuluhMalam->isBetween($startTime, $finishTime) ? 1 : 0;
    }

    private function diantaraJamPulangNormal()
    {
        $startTime = $this->carbonStartTime();
        $finishTime = $this->carbonFinishTime();

        $jamPulangNormal = $this->carbonJamPulangNormal();

        return $jamPulangNormal->isBetween($startTime, $finishTime);
    }

    private function diantaraJamPulangSabtu()
    {
        $startTime = $this->carbonStartTime();
        $finishTime = $this->carbonFinishTime();

        $jamPulangSabtu = $this->carbonJamPulangSabtu();

        return $jamPulangSabtu->isBetween($startTime, $finishTime);
    }

    private function diantaraIstirahatPertama()
    {
        $startTime = $this->carbonStartTime();
        $finishTime = $this->carbonFinishTime();

        $istirahatPertama = $this->carbonIstirahatPertama();

        return $istirahatPertama->isBetween($startTime, $finishTime);
    }

    private function diantaraIstirahatKedua()
    {
        $startTime = $this->carbonStartTime();
        $finishTime = $this->carbonFinishTime();

        $istirahatKedua = $this->carbonIstirahatKedua();

        return $istirahatKedua->isBetween($startTime, $finishTime);
    }

    private function carbonStartTime()
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->start_time);
    }

    private function carbonFinishTime()
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->finish_time);
    }

    private function carbonJamPulangNormal()
    {
        $startTime = $this->carbonStartTime();
        $currentDate = $startTime->format('Y-m-d');

        return Carbon::createFromFormat('Y-m-d H:i:s', $currentDate . ' 16:00:00');
    }

    private function carbonJamPulangSabtu()
    {
        $startTime = $this->carbonStartTime();
        $currentDate = $startTime->format('Y-m-d');

        return Carbon::createFromFormat('Y-m-d H:i:s', $currentDate . ' 12:00:00');
    }

    private function carbonJamSepuluhMalam()
    {
        $startTime = $this->carbonStartTime();
        $currentDate = $startTime->format('Y-m-d');

        return Carbon::createFromFormat('Y-m-d H:i:s', $currentDate . ' 22:00:00');
    }

    private function carbonIstirahatPertama()
    {
        $startTime = $this->carbonStartTime();
        $currentDate = $startTime->format('Y-m-d');

        return Carbon::createFromFormat('Y-m-d H:i:s', $currentDate . ' 13:00:00');
    }

    private function carbonIstirahatKedua()
    {
        $startTime = $this->carbonStartTime();
        $currentDate = $startTime->format('Y-m-d');

        return Carbon::createFromFormat('Y-m-d H:i:s', $currentDate . ' 19:00:00');
    }
}
