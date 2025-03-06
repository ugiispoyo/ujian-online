@extends('layouts.dashboard')

@section('content')
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-4">Monitoring Lomba: {{ $lomba->nama_lomba }}</h1>

        <div class="mb-4 p-4 bg-gray-100 border rounded">
            <h2 class="text-lg font-semibold">Sisa Waktu Ujian:</h2>
            <p id="countdown" class="text-xl font-bold text-yellow-400"></p>
            <p id="completed" class="text-xl font-bold text-red-500"></p>
            <form action="{{ route('admin.lomba.complete', $lomba->id) }}" method="POST">
                @csrf
                @method('PUT')
                <button id="btn-complete" class="border border-gray-500 px-4 py-2 rounded-lg mt-2"
                    style="display: none;">Selesaikan</button>
            </form>
        </div>

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
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Ambil waktu lomba dan durasi dari PHP
            const waktuLomba = new Date("{{ $lomba->waktu_lomba }}");
            const durasi = {{ $lomba->durasi }}; // dalam menit

            // Hitung waktu selesai lomba
            const waktuSelesai = new Date(waktuLomba.getTime() + durasi * 60000);

            function updateCountdown() {
                const now = new Date();
                const timeRemaining = waktuSelesai - now;

                if (timeRemaining <= 0) {
                    document.getElementById("countdown").innerHTML = "";
                    document.getElementById("completed").innerHTML = "Waktu habis";
                    document.getElementById("btn-complete").style.display = "block";
                    return;
                }

                const hours = Math.floor(timeRemaining / (1000 * 60 * 60));
                const minutes = Math.floor((timeRemaining % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((timeRemaining % (1000 * 60)) / 1000);

                document.getElementById("countdown").innerHTML =
                    (hours > 0 ? hours + " jam " : "") + minutes + " menit " + seconds + " detik";
            }

            // Update countdown setiap detik
            updateCountdown();
            setInterval(updateCountdown, 1000);
        });
    </script>
@endsection
