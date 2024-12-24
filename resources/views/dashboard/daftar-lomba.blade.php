@extends('layouts.dashboard')

@section('content')
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-6">Daftar Lomba</h1>

        <!-- Grid Card -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($lombas as $lomba)
                <div
                    class="max-w-sm bg-white border border-gray-200 rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                    @if ($lomba->gambar)
                        <img src="{{ Storage::url($lomba->gambar) }}" alt="Gambar lomba" class="w-full h-48 object-cover">
                    @else
                        <img src="{{ asset('default-image.jpg') }}" alt="Default gambar lomba"
                            class="w-full h-48 object-cover">
                    @endif
                    <div class="p-5">
                        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900">
                            {{ $lomba->nama_lomba }}
                        </h5>
                        <p class="text-sm text-gray-500">
                            {{ \Carbon\Carbon::parse($lomba->waktu_lomba)->locale('id')->translatedFormat('l, d F Y H:i') }}
                        </p>
                        <p class="text-sm text-gray-500 mb-3">Biaya pendaftaran: Rp
                            {{ number_format($lomba->harga_pendaftaran, 2) }}</p>

                        @php
                            $waktuLomba = \Carbon\Carbon::parse($lomba->waktu_lomba);
                            $now = \Carbon\Carbon::now();
                            $isDisabled = $now->diffInHours($waktuLomba, false) < 3 && $now->lt($waktuLomba);
                        @endphp

                        <a href="{{ $isDisabled ? '#' : route('pendaftaran-lomba.create', $lomba->id) }}"
                            class="inline-flex items-center px-3 py-2 text-sm font-medium text-center {{ $isDisabled ? 'bg-gray-400 cursor-not-allowed' : 'bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300' }} text-white rounded-lg">
                            {{ $isDisabled ? 'Pendaftaran Ditutup' : 'Daftar Sekarang' }}
                            @if (!$isDisabled)
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3">
                                    </path>
                                </svg>
                            @endif
                        </a>
                    </div>
                </div>
            @empty
                <p class="text-gray-500 text-center">Belum ada lomba yang tersedia.</p>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $lombas->links('pagination::tailwind') }}
        </div>
    </div>
@endsection
