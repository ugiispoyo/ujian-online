<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FirebaseService;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Admin;

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
            // 'password' => 'required|min:8|confirmed',
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
            'password' => Hash::make("1234567890"), /* Default password, untuk bypass karena loginnya nanti dari gmail */
        ]);

        /* setelah berhasil register, langsung login */
        $user = User::where('email', $validatedData['email'])->first();
        if ($user) {
            Auth::guard('web')->login($user);
            $request->session()->regenerate();
            return redirect()->route('dashboard')->with('success', 'Login sebagai siswa berhasil!');
        }

        return back()->withErrors(['email' => 'Email atau password salah.'])->onlyInput('email');
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
            return response()->json(["error" => "ID Token tidak ditemukan"], 400);
        }

        try {
            $firebaseUser = $this->firebaseService->verifyIdToken($idToken);
            Log::info('Verifikasi ID Token berhasil.');

            $email = $firebaseUser->claims()->get('email');
            Log::info('Email dari Firebase: ' . $email);

            $user = User::where('email', $email)->first();
            $admin = Admin::where('email', $email)->first();

            if (!$user && !$admin) {
                Log::warning('Email tidak ditemukan di database: ' . $email);
                return response()->json(["error" => "Email tidak ditemukan, silahkan register terlebih dahulu"], 404);
            }

            if ($admin) {
                Auth::guard('admin')->login($admin);
                $request->session()->regenerate();
                Log::info('Login berhasil untuk admin: ' . $admin->name);
                return response()->json(["redirect" => "/admin/dashboard"]);
            }

            if ($user) {
                Auth::guard('web')->login($user);
                $request->session()->regenerate();
                Log::info('Login berhasil untuk user: ' . $user->name);
                return response()->json(["redirect" => "/dashboard"]);
            }
        } catch (\Exception $e) {
            Log::error('Gagal memproses login dengan Gmail: ' . $e->getMessage());
            return response()->json(['all' => 'Gagal memproses login dengan Gmail: ' . $e->getMessage()], 500);
        }
    }

    public function checkEmailExists(Request $request)
    {
        $email = $request->input('email');
        $user = User::where('email', $email)->first();
        $admin = Admin::where('email', $email)->first();

        if ($admin) {
            Auth::guard('admin')->login($admin);
            $request->session()->regenerate();
            Log::info('Akun sudah terdaftar sebagai admin: ' . $admin->name);
            return response()->json(["redirect" => "/admin/dashboard"]);
        }

        if ($user) {
            Auth::guard('web')->login($user);
            $request->session()->regenerate();
            Log::info('Akun sudah terdaftar sebagai user: ' . $user->name);
            return response()->json(["redirect" => "/dashboard"]);
        }

        return response()->json(['exists' => false]);
    }


    public function logout(Request $request)
    {
        Log::info('Proses logout dimulai.');

        // Logout untuk user biasa (web)
        if (Auth::guard('web')->check()) {
            Log::info('User biasa terdeteksi, melakukan logout.');
            Auth::guard('web')->logout();
        }

        // Logout untuk admin
        if (Auth::guard('admin')->check()) {
            Log::info('Admin terdeteksi, melakukan logout.');
            Auth::guard('admin')->logout();
        }

        // Hapus semua sesi dan regenerasi token
        if ($request->hasSession()) {
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        } else {
            Log::error('Session tidak tersedia pada request.');
        }

        Log::info('Logout berhasil, session dihapus.');

        return redirect('/login')->with('success', 'Logout berhasil.');
    }
}
