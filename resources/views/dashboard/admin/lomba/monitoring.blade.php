@extends('layouts.dashboard')

@section('content')
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-4">Monitoring Lomba: {{ $lomba->nama_lomba }}</h1>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th class="px-6 py-3">Nama Peserta</th>
                        <th class="px-6 py-3">Status Ujian</th>
                        <th class="px-6 py-3">Soal Terjawab</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($roomTes as $room)
                        @php
                            $peserta = $room->siswa; // Menggunakan relasi siswa
                            $soalTerjawab = is_array($room->soal_terjawab) ? count($room->soal_terjawab) : 0;
                            $totalSoal = $lomba->total_soal; // Menggunakan helper dari model
                        @endphp
                        <tr class="border-b dark:border-gray-700">
                            <td class="px-6 py-4">
                                {{ $peserta ? $peserta->name : 'Peserta Tidak Ditemukan' }}
                            </td>
                            <td class="px-6 py-4">
                                @if ($room->status === 'draft')
                                    <span class="text-yellow-500">Sedang Mengerjakan</span>
                                @else
                                    <span class="text-green-500">Selesai</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                {{ $soalTerjawab }} / {{ $totalSoal }} Soal
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
