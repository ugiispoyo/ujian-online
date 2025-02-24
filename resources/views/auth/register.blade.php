@extends('layouts.app')

@section('content')
    <div class="max-w-md w-full mx-auto bg-white p-8 rounded-lg shadow-md">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <h2 class="text-2xl font-bold text-center mb-6">Register</h2>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        <div class="mt-4" id="googleLoginSection">
            <button onclick="loginWithGoogle()"
                class="w-full bg-gray-700 text-white py-2 rounded flex items-center justify-center">
                <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
                    <path fill="#4285F4"
                        d="M44.5 20H24v8.5h11.7C34.5 34.3 29.9 38 24 38c-7 0-12.7-5.7-12.7-12.7S17 12.7 24 12.7c3.2 0 6.1 1.2 8.3 3.1l6.2-6.2C34.2 6.6 29.4 4.5 24 4.5 12.4 4.5 3.5 13.4 3.5 25S12.4 45.5 24 45.5C36.4 45.5 44 36.6 44 25c0-1.7-.2-3.3-.5-5z" />
                    <path fill="#34A853"
                        d="M6.2 14.9l6.5 4.8C14.5 15.3 19 12.7 24 12.7c3.2 0 6.1 1.2 8.3 3.1l6.2-6.2C34.2 6.6 29.4 4.5 24 4.5 16.8 4.5 10.4 8.9 6.2 14.9z" />
                    <path fill="#FBBC05"
                        d="M24 45.5c5.4 0 10-2.1 13.5-5.5l-6.2-6.2c-2.2 1.9-5.1 3.1-8.3 3.1-5.9 0-10.5-3.8-11.8-9.1L6.2 33C10.4 40.1 16.8 45.5 24 45.5z" />
                    <path fill="#EA4335"
                        d="M44.5 20H24v8.5h11.7c-.9 3.7-3.9 6.7-7.7 7.7v6.2h7.8C39.9 38.7 44 32.8 44 25c0-1.7-.2-3.3-.5-5z" />
                </svg>
                Login terlebih dahulu dengan Gmail
            </button>
        </div>
        <form action="{{ url('/register') }}" method="POST" class="space-y-5" id="registrationForm" style="display:none;">
            @csrf
            <div>
                <label for="nama" class="block mb-2 text-sm font-medium text-gray-700">Nama</label>
                <input type="text" name="nama" id="nama" value="{{ old('nama') }}" required
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3">
                @error('nama')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="nik" class="block mb-2 text-sm font-medium text-gray-700">NIK</label>
                <input type="text" name="nik" id="nik" value="{{ old('nik') }}" required
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3">
                @error('nik')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="jenis_kelamin" class="block mb-2 text-sm font-medium text-gray-700">Jenis Kelamin</label>
                <select name="jenis_kelamin" id="jenis_kelamin" required
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3">
                    <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                </select>
                @error('jenis_kelamin')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="tanggal_lahir" class="block mb-2 text-sm font-medium text-gray-700">Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3">
                @error('tanggal_lahir')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="alamat" class="block mb-2 text-sm font-medium text-gray-700">Alamat</label>
                <textarea name="alamat" id="alamat" required
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3">{{ old('alamat') }}</textarea>
                @error('alamat')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="sekolah" class="block mb-2 text-sm font-medium text-gray-700">Sekolah</label>
                <input type="text" name="sekolah" id="sekolah" value="{{ old('sekolah') }}" required
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3">
                @error('sekolah')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="kelas" class="block mb-2 text-sm font-medium text-gray-700">Kelas</label>
                <input type="text" name="kelas" id="kelas" value="{{ old('kelas') }}" required
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3">
                @error('kelas')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="email" class="block mb-2 text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" id="email" readonly
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3">
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            {{-- <div>
                <label for="password" class="block mb-2 text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" id="password" required
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3">
                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="password_confirmation" class="block mb-2 text-sm font-medium text-gray-700">Konfirmasi
                    Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3">
            </div> --}}
            <button type="submit"
                class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-3 text-center">Daftar</button>
        </form>

    </div>


    <script type="module">
        // Import Firebase dan Authentication dari CDN
        import {
            initializeApp
        } from "https://www.gstatic.com/firebasejs/11.3.1/firebase-app.js";
        import {
            getAuth,
            signInWithPopup,
            GoogleAuthProvider
        } from "https://www.gstatic.com/firebasejs/11.3.1/firebase-auth.js";

        // Konfigurasi Firebase
        const firebaseConfig = {
            apiKey: "AIzaSyD_-SmZYGEdOf3zIgi_29_KlncXMIhUaBg",
            authDomain: "ujian-online-29118.firebaseapp.com",
            projectId: "ujian-online-29118",
            storageBucket: "ujian-online-29118.firebasestorage.app",
            messagingSenderId: "696210059320",
            appId: "1:696210059320:web:859813bf0828723381b6cd"
        };

        // Inisialisasi Firebase App dan Auth
        const app = initializeApp(firebaseConfig);
        const auth = getAuth(app);
        const googleProvider = new GoogleAuthProvider();

        googleProvider.setCustomParameters({
            prompt: 'select_account'
        });

        // Fungsi Login dengan Gmail
        window.loginWithGoogle = function() {
            signInWithPopup(auth, googleProvider)
                .then((result) => {
                    const user = result.user;

                    fetch('/auth/google/check-email', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                    'content')
                            },
                            body: JSON.stringify({
                                email: user.email
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.redirect) {
                                window.location.href = data.redirect;
                                return;
                            }
                            document.getElementById('googleLoginSection').style.display = 'none';
                            document.getElementById('registrationForm').style.display = 'block';
                            document.getElementById('email').value = user.email;
                            document.getElementById('nama').value = user.displayName;
                        });
                })
                .catch((error) => {
                    console.error('Gagal login dengan Google:', error);
                });
        };
    </script>
@endsection
