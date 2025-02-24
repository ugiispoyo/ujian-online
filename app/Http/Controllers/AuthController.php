<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FirebaseService;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    protected $firebaseService;

    public function __construct(FirebaseService $firebaseService)
    {
        $this->firebaseService = $firebaseService;
    }

    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'nik' => 'required|numeric|unique:users,nik',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string',
            'sekolah' => 'required|string',
            'kelas' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        User::create([
            'name' => $validatedData['nama'],
            'nik' => $validatedData['nik'],
            'jenis_kelamin' => $validatedData['jenis_kelamin'],
            'tanggal_lahir' => $validatedData['tanggal_lahir'],
            'alamat' => $validatedData['alamat'],
            'sekolah' => $validatedData['sekolah'],
            'kelas' => $validatedData['kelas'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        return redirect('/login')->with('success', 'Registrasi berhasil! Silakan login.');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Cek login sebagai admin
        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('dashboard-admin')->with('success', 'Login sebagai admin berhasil!');
        }

        // Cek login sebagai siswa
        if (Auth::guard('web')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('dashboard')->with('success', 'Login sebagai siswa berhasil!');
        }

        // Jika login gagal
        return back()->withErrors(['email' => 'Email atau password salah.'])->onlyInput('email');
    }

    public function handleGoogleCallback(Request $request)
    {
        $idToken = $request->input('idToken');

        // Log ID Token untuk memastikan data diterima
        Log::info('ID Token diterima: ' . json_encode($idToken));

        if (!$idToken) {
            Log::error('ID Token tidak ditemukan.');
            return back()->withErrors(['id' => 'ID Token tidak ditemukan. Silakan coba login ulang.']);
        }

        try {
            $firebaseUser = $this->firebaseService->verifyIdToken($idToken);
            Log::info('Verifikasi ID Token berhasil.');

            $email = $firebaseUser->claims()->get('email');
            Log::info('Email dari Firebase: ' . $email);

            $user = User::where('email', $email)->first();

            if (!$user) {
                Log::warning('Email tidak ditemukan di database: ' . $email);
                return back()->withErrors(['email' => 'Email tidak terdaftar. Silakan registrasi terlebih dahulu.']);
            }

            Auth::login($user);
            Log::info('Login berhasil untuk user: ' . $user->name);

            return redirect('/dashboard')->with('success', 'Login dengan Gmail berhasil!');
        } catch (\Exception $e) {
            Log::error('Gagal memproses login dengan Gmail: ' . $e->getMessage());
            return back()->withErrors(['all' =>  'Gagal memproses login dengan Gmail: ' . $e->getMessage()]);
        }
    }




    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Logout berhasil.');
    }
}
