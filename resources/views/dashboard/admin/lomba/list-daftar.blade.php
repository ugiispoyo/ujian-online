@extends('layouts.dashboard')

@section('content')
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-4">Daftar Pendaftaran Lomba</h1>

        <!-- Filter dan Pencarian -->
        <div class="flex items-center mb-4">
            <form action="{{ route('admin.pendaftaran-lomba.index') }}" method="GET" class="flex space-x-4">
                <!-- Input Pencarian -->
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari siswa atau lomba..."
                    class="px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring focus:ring-blue-200">

                <!-- Filter Lomba -->
                <select name="filter_lomba"
                    class="px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring focus:ring-blue-200">
                    <option value="" disabled {{ !request('filter_lomba') ? 'selected' : '' }}>Filter Lomba</option>
                    @foreach ($lombas as $lomba)
                        <option value="{{ $lomba->id }}" {{ request('filter_lomba') == $lomba->id ? 'selected' : '' }}>
                            {{ $lomba->nama_lomba }}
                        </option>
                    @endforeach
                </select>

                <!-- Tombol Cari -->
                <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 focus:ring-4 focus:ring-blue-300">
                    Cari
                </button>
            </form>

            <!-- Tombol Clear Filter -->
            @if (request('filter_lomba') || request('search'))
                <a href="{{ route('admin.pendaftaran-lomba.index') }}"
                    class="ml-4 px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400 focus:ring-4 focus:ring-gray-500">
                    Clear Filter
                </a>
            @endif
        </div>

        <!-- Tabel Pendaftaran -->
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">Nama Siswa</th>
                        <th scope="col" class="px-6 py-3">Nama Lomba</th>
                        <th scope="col" class="px-6 py-3">Tanggal Transfer</th>
                        <th scope="col" class="px-6 py-3">Bukti Pembayaran</th>
                        <th scope="col" class="px-6 py-3">Status</th>
                        <th scope="col" class="px-6 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pendaftaran as $data)
                        <tr
                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                {{ $data->siswa->name }}
                            </td>
                            <td class="px-6 py-4">{{ $data->lomba->nama_lomba }}</td>
                            <td class="px-6 py-4">{{ \Carbon\Carbon::parse($data->tanggal_transfer)->format('d-m-Y') }}</td>
                            <td class="px-6 py-4">
                                @if ($data->bukti_transfer)
                                    <img src="{{ Storage::url($data->bukti_transfer) }}" alt="Bukti Transfer"
                                        class="w-20 h-20 object-cover rounded cursor-pointer"
                                        onclick="showImageModal('{{ Storage::url($data->bukti_transfer) }}')">
                                @else
                                    <span class="text-gray-500">Tidak ada bukti</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="px-2 py-1 rounded {{ $data->status === 'verified' ? 'bg-green-200 text-green-700' : 'bg-red-200 text-red-700' }}">
                                    {{ ucfirst($data->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @if ($data->status === 'unverified')
                                    <form action="{{ route('admin.pendaftaran-lomba.confirm', $data->id) }}"
                                        method="POST">
                                        @csrf
                                        <button type="submit" class="text-blue-500 hover:underline">Konfirmasi</button>
                                    </form>
                                @else
                                    <span class="text-gray-500">Sudah Terkonfirmasi</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-gray-500">Tidak ada pendaftaran yang tersedia.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $pendaftaran->links('pagination::tailwind') }}
        </div>
    </div>

    <!-- Modal View Gambar -->
    <div id="image-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="relative bg-white rounded-lg shadow-md p-7 w-full max-w-3xl max-h-[80%] overflow-auto">
            <!-- Tombol Close -->
            <button onclick="hideImageModal()"
                class="absolute top-[2px] right-2 text-gray-600 hover:text-gray-900 focus:outline-none text-2xl">
                &times;
            </button>
            <img id="modal-image" src="" alt="Gambar Bukti" class="max-w-full h-auto rounded">
        </div>
    </div>


    <script>
        function showImageModal(imageUrl) {
            const modal = document.getElementById('image-modal');
            const modalImage = document.getElementById('modal-image');
            modalImage.src = imageUrl;
            modal.classList.remove('hidden');
        }

        function hideImageModal() {
            const modal = document.getElementById('image-modal');
            modal.classList.add('hidden');
        }
    </script>
@endsection
