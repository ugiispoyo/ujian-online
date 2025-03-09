@extends('layouts.dashboard')

@section('content')
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-4">Detail Lomba: {{ $lomba->nama_lomba }}</h1>

        <div class="mb-4">
            <strong>Waktu Lomba:</strong>
            {{ \Carbon\Carbon::parse($lomba->waktu_lomba)->locale('id')->translatedFormat('l, d F Y H:i') }}
        </div>

        <div class="mb-4">
            <strong>Durasi:</strong> {{ $lomba->durasi }} Menit
        </div>

        <div class="mb-4">
            <strong>Total Soal:</strong> {{ count($soalLomba) }}
        </div>

        <div class="mb-4">
            <strong>Total Terjawab:</strong> {{ count($soalTerjawab) }}
        </div>

        <a href="{{ route('events-siswa') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
            Kembali Ke List Event Lainnya
        </a>
    </div>
@endsection
