@extends('layouts.dashboard')

@section('content')
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-4">Daftar Lomba</h1>
        <a href="{{ route('admin.lomba.create') }}"
            class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block hover:bg-blue-600">
            Buat Lomba Baru
        </a>

        @if (session('success'))
            <div id="success-alert" class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Table -->
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">Nama Lomba</th>
                        <th scope="col" class="px-6 py-3">Deskripsi</th>
                        <th scope="col" class="px-6 py-3">Waktu Lomba</th>
                        <th scope="col" class="px-6 py-3">Harga Pendaftaran</th>
                        <th scope="col" class="px-6 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($lomba as $lomba)
                        <tr
                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ $lomba->nama_lomba }}</td>
                            <td class="px-6 py-4">{{ Str::limit($lomba->deskripsi, 50) }}</td>
                            <td class="px-6 py-4">{{ $lomba->waktu_lomba }}</td>
                            <td class="px-6 py-4">{{ number_format($lomba->harga_pendaftaran, 2) }}</td>
                            <td class="px-6 py-4">
                                <a href="{{ route('admin.lomba.edit', $lomba->id) }}"
                                    class="text-blue-500 hover:underline">Edit</a>
                                {{-- <form action="{{ route('admin.lomba.destroy', $lomba->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:underline ml-2"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus lomba ini?')">Hapus</button>
                                </form> --}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
