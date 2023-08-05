<x-auth.layout title="Laporan">

    <section class="grid grid-cols-1 gap-5">

        <div class="w-full bg-white p-5">
            <div class="table-responsive">
                <table class="table table-xs bordered">
                    <thead>
                        <tr>
                            <th class="text-center" rowspan="3">No</th>
                            <th class="text-center" rowspan="3">Nama</th>
                            <th class="text-center" rowspan="3">Jabatan</th>
                            <th class="text-center" rowspan="3">Hari</th>
                            <th class="text-center" rowspan="3">Status Hari</th>
                            <th class="text-center" rowspan="3">Jam Masuk</th>
                            <th class="text-center" rowspan="3">Jam Keluar</th>
                            <th class="text-center" colspan="5">Jam Lembur</th>
                            <th class="text-center" rowspan="3">Jam Kerja Normal</th>
                            <th class="text-center" rowspan="3">Jam Kerja Lembur</th>
                            <th class="text-center" rowspan="3">Total Jam Kerja</th>
                            <th class="text-center" rowspan="3">UM Normal</th>
                            <th class="text-center" rowspan="3">UM Lembur</th>
                        </tr>
                        <tr>
                            <th class="text-center normal-case">Jam I</th>
                            <th class="text-center normal-case">Jam II</th>
                            <th class="text-center normal-case">Jam III</th>
                            <th class="text-center normal-case">Jam IV</th>
                            <th class="text-center normal-case">Lembur > 4 Jam</th>
                        </tr>
                        <tr>
                            <th class="text-center normal-case">x 1.5</th>
                            <th class="text-center normal-case">x 2</th>
                            <th class="text-center normal-case">x 2</th>
                            <th class="text-center normal-case">x 2</th>
                            <th class="text-center normal-case">x 2</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($presences as $presence)
                            @php
                                $startTime = \Illuminate\Support\Carbon::parse($presence->start_time)->locale('id');
                                $startTime->settings(['formatFunction' => 'translatedFormat']);
                                
                                $finishTime = \Illuminate\Support\Carbon::parse($presence->finish_time)->locale('id');
                                $finishTime->settings(['formatFunction' => 'translatedFormat']);
                            @endphp
                            <tr
                                class="{{ ($presence->status == 'Libur' ? 'bg-red-100' : $presence->status == 'Sabtu') ? 'bg-blue-100' : 'bg-emerald-100' }}">
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $presence->employee_name }}</td>
                                <td>{{ $presence->jabatan }}</td>
                                <td>{{ $startTime->format('l') }}</td>
                                <td>{{ $presence->status }}</td>
                                <td class="text-center">
                                    {{ $startTime->format('d F Y H:i') }}
                                </td>
                                <td class="text-center">
                                    {{ $finishTime->format('d F Y H:i') }}
                                </td>
                                <td class="text-center">{{ $presence->first_hour_of_overtime }}</td>
                                <td class="text-center">{{ $presence->second_hour_of_overtime }}</td>
                                <td class="text-center">{{ $presence->third_hour_of_overtime }}</td>
                                <td class="text-center">{{ $presence->fourth_hour_of_overtime }}</td>
                                <td class="text-center">{{ $presence->more_than_four_hours_of_overtime }}</td>
                                <td class="text-center">{{ $presence->normal_hours }}</td>
                                <td class="text-center">{{ $presence->total_overtime }}</td>
                                <td class="text-center">{{ $presence->total_hours_worked }}</td>
                                <td class="text-center">{{ $presence->um_normal }}</td>
                                <td class="text-center">{{ $presence->um_lembur }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </section>

</x-auth.layout>
