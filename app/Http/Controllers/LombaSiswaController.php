<?php

namespace App\Http\Controllers;

use App\Models\Lomba;
use App\Models\RoomTes;
use App\Models\Soal;
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
        })
            ->orderBy('waktu_lomba', 'asc')
            ->get();

        // Ambil room ujian untuk user yang sedang login
        $userRooms = RoomTes::whereIn('id_lomba', $events->pluck('id'))
            ->where('id_siswa', $userId)
            ->get()
            ->mapWithKeys(function ($room) {
                return [$room->id_lomba => $room]; // Ubah menjadi key-value pair id_lomba => room
            });

        return view('dashboard.list-event', compact('events', 'userRooms'));
    }

    public function detail($id)
    {
        $userId = Auth::id();

        // Ambil data lomba
        $lomba = Lomba::findOrFail($id);

        // Ambil data soal dari tabel soal
        $soalData = Soal::where('id_lomba', $id)->first();

        // Ambil data room ujian pengguna saat ini
        $userRoom = RoomTes::where('id_lomba', $id)
            ->where('id_siswa', $userId)
            ->first();

        if (!$userRoom) {
            return redirect()->route('dashboard')->with('error', 'Anda belum mengikuti lomba ini.');
        }

        // Decode soal dan jawaban dari JSON ke array
        $soalLomba = is_string($soalData->soal) ? json_decode($soalData->soal, true) : $soalData->soal;
        $soalTerjawab = is_string($userRoom->soal_terjawab) ? json_decode($userRoom->soal_terjawab, true) : $userRoom->soal_terjawab;

        return view('dashboard.detail-event', compact('lomba', 'soalLomba', 'soalTerjawab'));
    }
}
