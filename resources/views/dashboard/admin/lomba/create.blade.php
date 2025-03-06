@extends('layouts.dashboard')

@section('content')
    <div class="bg-white p-6 rounded-lg shadow-md w-full md:max-w-lg mx-auto">
        <h2 class="text-2xl font-bold mb-4">Buat Lomba Baru</h2>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.lomba.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <div>
                <label for="nama_lomba" class="block mb-2 text-sm font-medium text-gray-700">Nama Lomba</label>
                <input type="text" name="nama_lomba" id="nama_lomba" value="{{ old('nama_lomba') }}" required
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
            </div>

            <div>
                <label for="deskripsi" class="block mb-2 text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea name="deskripsi" id="deskripsi" rows="4" required
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">{{ old('deskripsi') }}</textarea>
            </div>

            <div>
                <label for="gambar" class="block mb-2 text-sm font-medium text-gray-700">Upload Gambar</label>
                <input type="file" name="gambar" id="gambar"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
            </div>

            <div>
                <label for="waktu_lomba" class="block mb-2 text-sm font-medium text-gray-700">Waktu Lomba</label>
                <input type="datetime-local" name="waktu_lomba" id="waktu_lomba" value="{{ old('waktu_lomba') }}" required
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
            </div>

            <div>
                <label for="durasi" class="block mb-2 text-sm font-medium text-gray-700">Durasi Lomba (Dalam menit)</label>
                <input type="number" name="durasi" id="durasi" value="{{ old('durasi') }}" required
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
            </div>

            <div>
                <label for="harga_pendaftaran" class="block mb-2 text-sm font-medium text-gray-700">Harga
                    Pendaftaran</label>
                <input type="number" name="harga_pendaftaran" id="harga_pendaftaran" value="{{ old('harga_pendaftaran') }}"
                    required step="0.01"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
            </div>

            <button type="submit"
                class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                Simpan Lomba
            </button>
        </form>
    </div>
@endsection
