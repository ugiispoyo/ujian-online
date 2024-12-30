@extends('layouts.dashboard')

@section('content')
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-4">Buat Soal</h1>

        <!-- Pilih Lomba -->
        <div class="mb-6">
            <label for="id_lomba" class="block text-sm font-medium text-gray-700 mb-2">Pilih Lomba</label>
            <select id="id_lomba" class="block w-full px-4 py-2 border border-gray-300 rounded-lg">
                <option value="" selected disabled>Pilih lomba untuk soal</option>
                @foreach ($lombas as $lomba)
                    <option value="{{ $lomba->id }}" {{ request('id_lomba') == $lomba->id ? 'selected' : '' }}>
                        {{ $lomba->nama_lomba }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- React App -->
        @if (request('id_lomba'))
            <div id="soal-app"></div>
        @endif
    </div>
@endsection

@if (!app()->environment('production'))
    @viteReactRefresh
    @vite('resources/js/soal/create.jsx')
@endif

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const selectLomba = document.getElementById("id_lomba");

        if (!selectLomba) {
            console.error("Elemen select tidak ditemukan!");
            return;
        }

        selectLomba.addEventListener("change", function() {
            const selectedLomba = selectLomba.value;

            if (selectedLomba) {
                // Redirect ke halaman dengan query parameter
                window.location.href = `/admin/soal/create?id_lomba=${selectedLomba}`;
            }
        });
    });
</script>
