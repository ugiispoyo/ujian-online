@extends('layouts.app')

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="w-full max-w-md bg-white p-6 rounded shadow-md">
        <h2 class="text-2xl font-bold text-center mb-4">Login</h2>
        {{-- <form action="{{ url('/login') }}" method="POST" class="space-y-4">
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
        </form> --}}

        <div class="mt-4">
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
                Login dengan Gmail
            </button>
        </div>

        {{-- Menampilkan Error dengan Validation Error Bag --}}
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded my-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Menampilkan Error dari Session --}}
        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded my-4">
                <p>{{ session('error') }}</p>
            </div>
        @endif

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
                .then((result) => result.user.getIdToken())
                .then((idToken) => {
                    fetch('/auth/google/callback', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                    'content')
                            },
                            body: JSON.stringify({
                                idToken: idToken
                            })
                        })
                        .then(response => {
                            if (response.status === 403) {
                                alert('Akun anda telah diblokir, silahkan hubungi admin');
                                return;
                            }
                            if (!response.ok) {
                                alert('Akun anda tidak ditemukan, silahkan registrasi terlebih dahulu');
                                window.location.href = '/register';
                                return;
                            }
                            return response.json()
                        })
                        .then((data) => {
                            window.location.href = data.redirect;
                        }).catch((error) => {
                            console.error('Gagal mengirim ID Token ke backend:', error);
                        });
                })
                .catch((error) => {
                    console.error('Gagal login dengan Google:', error);
                });
        };
    </script>
@endsection
