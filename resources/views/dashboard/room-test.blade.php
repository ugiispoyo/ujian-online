@extends('layouts.dashboard')

@section('content')
    <div class="p-6 max-w-4xl mx-auto">
        <h1 class="text-2xl font-bold mb-4">Room Ujian: {{ $room->nama_room }}</h1>

        <!-- Form Soal -->
        <form action="#" method="POST">
            @csrf
            @foreach ($soalList as $index => $soal)
                <div class="mb-6 p-4 border rounded-md">
                    <!-- Tampilkan pertanyaan -->
                    <p class="font-semibold text-lg">{!! $soal['pertanyaan'] !!}</p>

                    <!-- Pilihan Jawaban -->
                    @foreach ($soal['jawaban'] as $key => $jawaban)
                        <label class="block mt-2">
                            <input type="radio" name="jawaban[{{ $index }}]" value="{{ $jawaban }}"
                                class="mr-2">
                            {!! $jawaban !!}
                        </label>
                    @endforeach
                </div>
            @endforeach

            <!-- Tombol Submit -->
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                Kumpulkan Jawaban
            </button>
        </form>
    </div>
@endsection
