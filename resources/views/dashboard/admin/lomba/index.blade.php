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
                        <th scope="col" class="px-6 py-3">Durasi lomba</th>
                        <th scope="col" class="px-6 py-3">Harga Pendaftaran</th>
                        <th scope="col" class="px-6 py-3">Status</th>
                        <th scope="col" class="px-6 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($lombas as $lomba)
                        @php
                            $jumlahPeserta = $lomba->pendaftaran->count(); // Relasi dengan tabel pendaftaran
                            $waktuLomba = \Carbon\Carbon::parse($lomba->waktu_lomba);
                            $now = \Carbon\Carbon::now();
                            $isDeletionAllowed = $jumlahPeserta < 10 && $now->diffInHours($waktuLomba, false) >= 3;
                        @endphp

                        <tr
                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ $lomba->nama_lomba }}</td>
                            <td class="px-6 py-4">{{ Str::limit($lomba->deskripsi, 50) }}</td>
                            <td class="px-6 py-4">
                                {{ $waktuLomba->locale('id')->translatedFormat('l, d F Y H:i') }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $lomba->durasi }} Menit
                            </td>
                            <td class="px-6 py-4">Rp {{ number_format($lomba->harga_pendaftaran, 2) }}</td>
                            <td>
                                @if ($lomba->status === 'not_started')
                                    <span class="text-yellow-400">Belum Mulai</span>
                                @elseif ($lomba->status === 'in_progress')
                                    <span class="text-green-500-400">Sedang Berlangsung</span>
                                @else
                                    Sudah Selesai
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex w-full flex-col items-start gap-2">
                                    {{-- Tombol "Mulai" hanya muncul jika waktu lomba belum lewat --}}
                                    @if ($lomba->status === 'not_started' && $now->lessThan($waktuLomba))
                                        @if ($lomba->soal)
                                            <form action="{{ route('admin.lomba.start', $lomba->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <button class="text-green-500 hover:underline">Mulai</button>
                                            </form>
                                        @else
                                            <p class="text-red-500">Belum bisa mulai, belum ada soal untuk lomba ini, input
                                                soal terlebih dahulu!</p>
                                        @endif
                                    @endif

                                    {{-- Tombol Monitoring hanya muncul saat lomba sedang berlangsung --}}
                                    @if ($lomba->status === 'in_progress')
                                        <a href="{{ route('admin.lomba.monitoring', $lomba->id) }}"
                                            class="text-purple-500 hover:underline">Monitoring</a>
                                    @endif

                                    {{-- Tombol Edit hanya muncul jika waktu lomba BELUM lewat --}}
                                    @if ($lomba->status !== 'in_progress' && $lomba->status !== 'completed' && $now->lessThan($waktuLomba))
                                        <a href="{{ route('admin.lomba.edit', $lomba->id) }}"
                                            class="text-blue-500 hover:underline">Edit</a>
                                    @endif

                                    @if (!$now->lessThan($waktuLomba) && $lomba->status === 'not_started')
                                        <span>Waktu lomba sudah lewat
                                            Silahkan <a href="{{ route('admin.lomba.edit', $lomba->id) }}"
                                                class="text-blue-500 hover:underline underline">Edit</a> tanggal
                                            lomba</span>
                                    @endif

                                    {{-- Tombol Hapus hanya muncul jika waktu lomba belum lewat dan pesertanya kurang dari 10 --}}
                                    @if ($isDeletionAllowed && $now->lessThan($waktuLomba) && $lomba->status === 'not_started')
                                        <button onclick="showModal('{{ $lomba->id }}')"
                                            class="text-red-500 hover:underline">Hapus</button>
                                    @endif

                                    @if ($lomba->status === 'completed')
                                        <a href="{{ route('admin.lomba.detail', $lomba->id) }}"
                                            class="text-blue-500 hover:underline">Detail</a>
                                    @endif

                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $lombas->links('pagination::tailwind') }}
        </div>
    </div>

    <!-- Modal Dialog -->
    <div id="delete-modal" class="fixed inset-0 bg-black bg-opacity-50 items-center justify-center hidden z-50">
        <div class="bg-white rounded-lg shadow-md p-6 w-full max-w-md">
            <h2 class="text-lg font-bold mb-4">Konfirmasi Hapus</h2>
            <p>Apakah Anda yakin ingin menghapus lomba ini?</p>
            <div class="mt-6 flex justify-end space-x-4">
                <button onclick="hideModal()"
                    class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400 focus:ring-2 focus:ring-gray-500">
                    Batal
                </button>
                <form id="delete-form" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 focus:ring-2 focus:ring-red-500">
                        Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function showModal(id) {
            const modal = document.getElementById('delete-modal');
            const form = document.getElementById('delete-form');
            form.action = `/admin/lomba/${id}`;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function hideModal() {
            const modal = document.getElementById('delete-modal');
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }
    </script>
@endsection
