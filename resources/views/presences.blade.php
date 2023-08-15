<x-auth.layout title="Kehadiran">

    @if (session('success'))
        <x-alert type="success" message="{{ session('success') }}" class="mb-5"></x-alert>
    @endif

    <section class="grid grid-cols-1 gap-5">

        <div class="w-full bg-white p-5">

            <form action="{{ route('presences.store') }}" method="POST">
                @csrf

                <div class="grid grid-cols-2 gap-5">

                    <div class="field">
                        <label class="label">Nama Pegawai</label>
                        <input type="text" class="control" name="employee_name">
                        @error('employee_name')
                            <p class="invalid-field">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="field">
                        <label class="label">Jabatan</label>
                        <input type="text" class="control" name="jabatan">
                        @error('jabatan')
                            <p class="invalid-field">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="field">
                        <label class="label">Jam Masuk</label>
                        <input type="datetime-local" class="control" name="start_time"
                            value="{{ old('start_time', date('Y-m-d 07:00', strtotime(now()))) }}">
                        @error('start_time')
                            <p class="invalid-field">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="field">
                        <label class="label">Jam Keluar</label>
                        <input type="datetime-local" class="control" name="finish_time"
                            value="{{ old('finish_time', date('Y-m-d 07:00', strtotime(now()))) }}">
                        @error('finish_time')
                            <p class="invalid-field">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="field">
                        <label class="label mb-5">Tanggal Merah</label>
                        <div class="flex items-center gap-5">
                            <div class="flex items-center gap-3">
                                <input type="checkbox" name="is_tanggal_merah" value="1" id="status_tanggal_merah">
                                <label class="label mb-0" for="status_tanggal_merah">Ya</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-span-2 flex justify-end">
                        <button type="submit" class="button primary">Submit</button>
                    </div>

                </div>

            </form>

        </div>

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
                            <th class="text-center" rowspan="3">#</th>
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
                                <td>
                                    <div class="flex items-center gap-3">

                                        <button type="button" class="modal-trigger"
                                            data-target="#deletePresenceModal-{{ $presence->id }}">
                                            <i class="text-lg text-red-500 uil uil-trash"></i>
                                        </button>

                                    </div>
                                </td>
                            </tr>

                            <div class="modal" id="deletePresenceModal-{{ $presence->id }}">
                                <div class="modal-content top">
                                    <div class="header">
                                        <h4>Apakah anda yakin? {{ $presence->id }}</h4>
                                    </div>
                                    <form action="{{ route('presences.destroy', ['presence' => $presence->id]) }}"
                                        method="POST" id="deletePresenceForm-{{ $presence->id }}">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                    <div class="footer flex justify-end gap-x-5">
                                        <button type="button"
                                            class="button bg-gray-100 shadow-none modal-cancel-trigger">Cancel</button>
                                        <button type="button" class="button bg-red-500 text-white form-trigger"
                                            data-target="#deletePresenceForm-{{ $presence->id }}"
                                            aria-label="Delete Account">
                                            Delete
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </section>

</x-auth.layout>
