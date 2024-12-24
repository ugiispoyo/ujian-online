@extends('layouts.dashboard')

@section('content')
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-4">Edit Soal</h1>

        <!-- React App -->
        @if (request('id_lomba'))
            <div id="soal-app"></div>
        @endif
        
    </div>
@endsection

@viteReactRefresh
@vite('resources/js/soal/create.jsx')