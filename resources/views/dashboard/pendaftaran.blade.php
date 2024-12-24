@extends('layouts.dashboard')

@section('content')
    <div class="p-6 bg-white rounded-lg shadow-md w-full max-w-lg mx-auto">
        <!-- Informasi Lomba -->
        <div class="mb-6 w-full">
            <h2 class="text-3xl font-bold mb-2">{{ $lomba->nama_lomba }}</h2>
            <div class="flex flex-col">
                <!-- Gambar Lomba -->
                <div class="w-full mb-4 lg:mb-0">
                    @if ($lomba->gambar)
                        <img src="{{ Storage::url($lomba->gambar) }}" alt="Gambar lomba"
                            class="w-full h-48 object-cover rounded-lg">
                    @else
                        <img src="{{ asset('default-image.jpg') }}" alt="Default gambar lomba"
                            class="w-full h-48 object-cover rounded-lg">
                    @endif
                </div>
                <!-- Detail Lomba -->
                <div class="w-full">
                    <p class="text-gray-700 mb-2"> {{ $lomba->deskripsi }}</p>
                    <p class="text-gray-700 mb-2"><strong>Waktu:</strong>
                        {{ \Carbon\Carbon::parse($lomba->waktu_lomba)->locale('id')->translatedFormat('l, d F Y H:i') }}
                    </p>
                    <p class="text-gray-700"><strong>Biaya Pendaftaran:</strong> Rp
                        {{ number_format($lomba->harga_pendaftaran, 2) }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Pesan Error Khusus -->
        @if ($errors->has('id_lomba'))
            <div class="mb-4 p-4 bg-red-100 text-red-700 border border-red-300 rounded-lg">
                <p>{{ $errors->first('id_lomba') }}</p>
            </div>
        @endif

        <h2 class="text-2xl font-bold mb-4">Pendaftaran Lomba</h2>
        <form action="{{ route('pendaftaran-lomba.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id_lomba" value="{{ $lomba->id }}">

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700" for="bukti_transfer">Upload Bukti Transfer</label>
                <input type="file" name="bukti_transfer" id="bukti_transfer" required
                    class="mt-1 block w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                @error('bukti_transfer')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700" for="tanggal_transfer">Tanggal Transfer</label>
                <input type="date" name="tanggal_transfer" id="tanggal_transfer" required
                    class="mt-1 block w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                @error('tanggal_transfer')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300">
                Daftar Lomba
            </button>
        </form>
    </div>
@endsection
