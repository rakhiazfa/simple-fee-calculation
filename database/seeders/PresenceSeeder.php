<?php

namespace Database\Seeders;

use App\Models\Presence;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class PresenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sabtu = Carbon::createFromFormat('Y-m-d H:i', '2023-08-05 07:00');
        $tempSabtu = Carbon::createFromFormat('Y-m-d H:i', '2023-08-05 07:00');

        for ($index = 1; $index <= 19; $index++) {

            sleep(1);

            $tempSabtu->addHours(1);

            Presence::create([
                'employee_name' => fake()->name(),
                'jabatan' => 'Fake',
                'start_time' => $sabtu->format('Y-m-d H:i'),
                'finish_time' => $tempSabtu->format('Y-m-d H:i'),
                'status' => 'Sabtu',
            ]);
        }

        $normal = Carbon::createFromFormat('Y-m-d H:i', '2023-08-07 07:00');
        $tempNormal = Carbon::createFromFormat('Y-m-d H:i', '2023-08-07 07:00');

        for ($index = 1; $index <= 19; $index++) {

            sleep(1);

            $tempNormal->addHours(1);

            Presence::create([
                'employee_name' => fake()->name(),
                'jabatan' => 'Fake',
                'start_time' => $normal->format('Y-m-d H:i'),
                'finish_time' => $tempNormal->format('Y-m-d H:i'),
                'status' => 'Normal',
            ]);
        }

        $minggu = Carbon::createFromFormat('Y-m-d H:i', '2023-08-06 07:00');
        $tempMinggu = Carbon::createFromFormat('Y-m-d H:i', '2023-08-06 07:00');

        for ($index = 1; $index <= 19; $index++) {

            sleep(1);

            $tempMinggu->addHours(1);

            Presence::create([
                'employee_name' => fake()->name(),
                'jabatan' => 'Fake',
                'start_time' => $minggu->format('Y-m-d H:i'),
                'finish_time' => $tempMinggu->format('Y-m-d H:i'),
                'status' => 'Libur',
            ]);
        }
    }
}
