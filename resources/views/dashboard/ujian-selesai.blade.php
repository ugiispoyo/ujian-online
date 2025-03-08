@extends('layouts.dashboard')

@section('content')
    <div class="p-6 max-w-2xl mx-auto bg-white shadow-md rounded-lg">
        <h1 class="text-2xl font-bold text-center text-gray-800 mb-4">Ujian Telah Selesai</h1>

        <div class="border-t border-gray-300 pt-4">
            <p class="text-lg"><strong>Nama Lomba:</strong> {{ $lomba->nama_lomba }}</p>
            <p class="text-lg"><strong>Durasi Ujian:</strong> {{ $lomba->durasi }} Menit</p>
        </div>

        <div class="mt-6 p-4 bg-gray-100 rounded-md text-center">
            <p class="text-lg font-semibold text-gray-700">
                Tes telah selesai. Silakan menunggu pengumuman untuk mendapatkan hasil nilai dan sertifikat.
            </p>
        </div>

        <div class="mt-6 flex justify-center">
            <a href="{{ route('dashboard') }}"
                class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                Kembali ke Dashboard
            </a>
        </div>
    </div>
@endsection
