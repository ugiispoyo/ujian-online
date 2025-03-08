@extends('layouts.dashboard')

@section('content')
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-6">List Lomba</h1>


        @if ($events->isEmpty())
            <div class="p-4 bg-gray-100 text-gray-600 text-center rounded-md">
                Anda belum mendaftar ke event manapun atau pendaftaran Anda belum diverifikasi.
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full border-collapse border border-gray-300">
                    <thead>
                        <tr class="bg-gray-200 text-gray-700">
                            <th class="border border-gray-300 px-4 py-2 text-left">Nama Lomba</th>
                            <th class="border border-gray-300 px-4 py-2 text-left">Status</th>
                            <th class="border border-gray-300 px-4 py-2 text-left">Deskripsi</th>
                            <th class="border border-gray-300 px-4 py-2 text-left">Gambar</th>
                            <th class="border border-gray-300 px-4 py-2 text-left">Waktu Lomba</th>
                            <th class="border border-gray-300 px-4 py-2 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($events as $event)
                            @php
                                $isAvailable = now()->gte($event->waktu_lomba);
                            @endphp
                            <tr class="border border-gray-300">
                                <td class="border border-gray-300 px-4 py-2">{{ $event->nama_lomba }}</td>
                                <td class="border border-gray-300 px-4 py-2">
                                    @if ($event->status === 'not_started')
                                        <span class="text-gray-500 rounded">Belum Dimulai</span>
                                    @elseif ($event->status === 'in_progress')
                                        <span class="text-blue-500 rounded">Sedang Berlangsung</span>
                                    @else
                                        <span class="text-green-500 rounded">Selesai</span>
                                    @endif
                                </td>
                                <td class="border border-gray-300 px-4 py-2">{{ Str::limit($event->deskripsi, 50) }}</td>
                                <td class="border border-gray-300 px-4 py-2">
                                    @if ($event->gambar)
                                        <img src="{{ asset('storage/' . $event->gambar) }}" alt="Gambar Lomba"
                                            class="h-12 w-12 object-cover rounded-md">
                                    @else
                                        <span class="text-gray-500">Tidak ada gambar</span>
                                    @endif
                                </td>
                                <td class="border border-gray-300 px-4 py-2">
                                    {{ \Carbon\Carbon::parse($event->waktu_lomba)->format('d M Y H:i') }}</td>
                                <td class="border border-gray-300 px-4 py-2 text-center w-[250px]">
                                    @if ($isAvailable)
                                        @if ($event->status === 'in_progress')
                                            <form action="{{ route('lomba.start', $event->id) }}" method="POST">
                                                @csrf
                                                <button type="submit"
                                                    class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                                                    Mulai
                                                </button>
                                            </form>
                                        @elseif ($event->status === 'completed')
                                            <a href="#"
                                                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                                                Detail
                                            </a>
                                        @endif
                                    @else
                                        <button class="px-4 py-2 bg-gray-400 text-white rounded-md cursor-not-allowed"
                                            disabled>
                                            Belum Dimulai
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        <!-- Pagination -->
        {{-- <div class="mt-6">
            {{ $lombas->links('pagination::tailwind') }}
        </div> --}}
    </div>
@endsection
