<?php

namespace App\Http\Controllers;

use App\Models\Lomba;
use Illuminate\Support\Facades\Auth;

class LombaSiswaController extends Controller
{
    public function index()
    {
        // Ambil semua data lomba dari database
        $lombas = Lomba::paginate(10);
        return view('dashboard.daftar-lomba', compact('lombas'));
    }

    public function list()
    {
        $userId = Auth::id();

        // Ambil event lomba yang sudah didaftarkan oleh user dan telah terverifikasi
        $events = Lomba::whereIn('id', function ($query) use ($userId) {
            $query->select('id_lomba')
                ->from('pendaftaran_lomba')
                ->where('id_siswa', $userId)
                ->where('status', 'verified'); // Hanya yang terverifikasi
        })->orderBy('waktu_lomba', 'asc')->get();

        return view('dashboard.list-event', compact('events'));
    }
}
