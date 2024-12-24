@extends('layouts.dashboard')

@section('content')
    <div class="container mx-auto p-6 bg-white rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-6">Daftar Soal</h2>
        <a href="{{ route('admin.soal.create') }}"
            class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block hover:bg-blue-600">
            Buat Soal Baru
        </a>


        <div class="overflow-x-auto">
            <table
                class="table-auto w-full text-sm text-left text-gray-500 dark:text-gray-400 border-collapse border border-gray-200">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3 border border-gray-300 w-[20px]">
                            No
                        </th>
                        <th scope="col" class="px-6 py-3 border border-gray-300">
                            Nama Lomba
                        </th>
                        <th scope="col" class="px-6 py-3 border border-gray-300 text-center">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($soals as $index => $soal)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td class="px-6 py-4 border border-gray-300">
                                {{ $index + 1 }}
                            </td>
                            <td class="px-6 py-4 border border-gray-300">
                                {{ $soal->lomba->nama_lomba ?? 'Tidak Diketahui' }}
                            </td>
                            <td class="px-6 py-4 border border-gray-300 text-center">
                                <a class="text-blue-500" href="{{ route('admin.soal.edit', ['id_lomba' => $soal->lomba->id]) }}">Edit Soal</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $soals->links('pagination::tailwind') }}
        </div>
    </div>
@endsection
