@extends('layouts.dashboard')

@section('content')
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-4">Detail Lomba: {{ $lomba->nama_lomba }}</h1>

        <div class="mb-4">
            <strong>Waktu Lomba:</strong>
            {{ \Carbon\Carbon::parse($lomba->waktu_lomba)->locale('id')->translatedFormat('l, d F Y H:i') }}
        </div>

        <form method="GET" class="mb-4 flex gap-4 items-center">
            <input type="text" name="nama" placeholder="Cari peserta..." value="{{ request('nama') }}"
                class="border px-4 py-2 rounded">

            <select name="sort_nilai" class="border px-4 py-2 rounded">
                <option value="">Urutkan Nilai</option>
                <option value="desc" {{ request('sort_nilai') == 'desc' ? 'selected' : '' }}>Tertinggi</option>
                <option value="asc" {{ request('sort_nilai') == 'asc' ? 'selected' : '' }}>Terendah</option>
            </select>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Filter</button>

            {{-- Tombol Reset (X) hanya muncul jika filter aktif --}}
            @if (request()->has('nama') || request()->has('sort_nilai'))
                <a href="{{ route('admin.lomba.detail', $lomba->id) }}" class="text-red-500 font-bold text-lg ml-2">✕</a>
            @endif
        </form>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th class="px-6 py-3">Nama Peserta</th>
                        <th class="px-6 py-3">Total Soal</th>
                        <th class="px-6 py-3">Total Soal Terjawab</th>
                        <th class="px-6 py-3">Total Jawaban Yang Benar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($peserta as $room)
                        @php
                            $totalSoal = is_array($soalLomba) ? count($soalLomba) : 0;
                            $soalTerjawab = is_array($room->soal_terjawab) ? count($room->soal_terjawab) : 0;
                        @endphp
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td class="px-6 py-4">{{ $room->siswa->name ?? 'Tidak Diketahui' }}</td>
                            <td class="px-6 py-4">{{ $totalSoal }}</td>
                            <td class="px-6 py-4">{{ $soalTerjawab }}</td>
                            <td class="px-6 py-4 font-bold text-green-500">{{ $room->nilai }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $peserta->links('pagination::tailwind') }}
        </div>
    </div>
@endsection
