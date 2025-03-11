@extends('layouts.dashboard')

@section('content')
    <div class="container mx-auto p-6">
        <h2 class="text-2xl font-bold mb-4">Daftar Pengguna</h2>

        <!-- Filter Pencarian -->
        <form method="GET" action="{{ route('admin.users.index') }}" class="mb-4 flex items-center gap-2">
            <input type="text" name="name" placeholder="Cari berdasarkan nama..." value="{{ request('name') }}"
                class="p-2 border border-gray-300 rounded-lg w-64 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <button type="submit" class="p-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">Cari</button>

            <!-- Tombol Hapus Filter -->
            @if (request('name'))
                <a href="{{ route('admin.users.index') }}"
                    class="p-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition">
                    Hapus Filter
                </a>
            @endif
        </form>

        <!-- Tabel Data User -->
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th class="py-3 px-6 text-left">Nama</th>
                        <th class="py-3 px-6 text-left">Email</th>
                        <th class="py-3 px-6 text-center">Jenis Kelamin</th>
                        <th class="py-3 px-6 text-center">Tanggal Lahir</th>
                        <th class="py-3 px-6 text-left">Alamat</th>
                        <th class="py-3 px-6 text-left">Sekolah</th>
                        <th class="py-3 px-6 text-center">Kelas</th>
                        <th class="py-3 px-6 text-center">Status</th>
                        <th class="py-3 px-6 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 text-sm">
                    @forelse($users as $user)
                        <tr
                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="py-3 px-6">{{ $user->name }}</td>
                            <td class="py-3 px-6">{{ $user->email }}</td>
                            <td class="py-3 px-6 text-center">{{ ucfirst($user->jenis_kelamin) }}</td>
                            <td class="py-3 px-6 text-center">{{ $user->tanggal_lahir }}</td>
                            <td class="py-3 px-6">{{ $user->alamat }}</td>
                            <td class="py-3 px-6">{{ $user->sekolah }}</td>
                            <td class="py-3 px-6 text-center">{{ $user->kelas }}</td>

                            <!-- Status -->
                            <td class="py-3 px-6 text-center">
                                @if ($user->status === 'active')
                                    <span class="px-2 py-1 bg-green-200 text-green-800 rounded-full">Active</span>
                                @else
                                    <span class="px-2 py-1 bg-red-200 text-red-800 rounded-full">Blocked</span>
                                @endif
                            </td>

                            <!-- Tombol Block/Unblock -->
                            <td class="py-3 px-6 text-center">
                                <form action="{{ route('admin.users.toggleStatus', $user->id) }}" method="POST"
                                    onsubmit="return confirm('Apakah Anda yakin ingin mengubah status pengguna ini?');">
                                    @csrf
                                    @method('PATCH')

                                    @if ($user->status === 'active')
                                        <button type="submit"
                                            class="px-3 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600 transition">
                                            Block
                                        </button>
                                    @else
                                        <button type="submit"
                                            class="px-3 py-1 bg-green-500 text-white rounded-lg hover:bg-green-600 transition">
                                            Unblock
                                        </button>
                                    @endif
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-4 text-gray-500">Tidak ada data pengguna.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>
@endsection
