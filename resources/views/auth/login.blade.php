@extends('layouts.app')

@section('content')
    <div class="w-full max-w-md bg-white p-6 rounded shadow-md">
        <h2 class="text-2xl font-bold text-center mb-4">Login</h2>
        <form action="{{ url('/login') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="email" class="block text-sm font-medium">Email</label>
                <input type="email" name="email" id="email" required
                    class="w-full border-gray-300 rounded mt-1 px-3 py-2">
            </div>
            <div>
                <label for="password" class="block text-sm font-medium">Password</label>
                <input type="password" name="password" id="password" required
                    class="w-full border-gray-300 rounded mt-1 px-3 py-2">
            </div>
            <button type="submit" class="w-full bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">
                Login
            </button>
        </form>
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded my-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

    </div>
@endsection
