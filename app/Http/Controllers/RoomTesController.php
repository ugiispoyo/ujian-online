<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RoomTes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Lomba;
use App\Models\Soal;

class RoomTesController extends Controller
{

    public function startTest($id)
    {
        $userId = Auth::id();

        // Cek apakah lomba ada dan sedang berlangsung
        $lomba = Lomba::findOrFail($id);
        if ($lomba->status !== 'in_progress' && $lomba->status !== 'completed') {
            return redirect()->route('events-siswa')->with('error', 'Tes belum bisa dimulai.');
        }

        if ($lomba->status === 'completed') {
            return redirect()->route('ujian.selesai')->with('error', 'Tes sudah selesai.');
        }

        // Cek apakah user sudah memiliki room ujian untuk lomba ini
        $room = RoomTes::where('id_lomba', $id)
            ->where('id_siswa', $userId)
            ->first();

        if (!$room) {
            // Buat room baru jika belum ada
            $room = RoomTes::create([
                'id' => Str::uuid(),
                'id_lomba' => $id,
                'id_siswa' => $userId,
                'nama_room' => 'Room Tes - ' . $lomba->nama_lomba,
                'durasi' => $lomba->durasi,
                'status' => 'draft',
                'nilai' => 0,
            ]);
        }

        // Redirect ke halaman Room Ujian
        return redirect()->route('room.tes.show', $room->id);
    }

    public function show($id)
    {
        // Ambil room ujian berdasarkan id
        $room = RoomTes::where('id', $id)->where('id_siswa', Auth::id())->firstOrFail();

        // Kirim data ke view
        return view('layouts.test', compact('room'));
    }

    public function getSoal($id)
    {
        // Cek apakah room tes ada untuk user saat ini
        $room = RoomTes::where('id', $id)
            ->first();

        if (!$room) {
            return response()->json(['message' => 'Room Tes tidak ditemukan.'], 404);
        }

        // Ambil soal dari tabel `soal` berdasarkan `id_lomba`
        $soalData = Soal::where('id_lomba', $room->id_lomba)->first();

        if (!$soalData) {
            return response()->json(['message' => 'Soal belum tersedia.'], 404);
        }

        // Decode soal JSON
        $soalList = is_string($soalData->soal) ? json_decode($soalData->soal, true) : $soalData->soal;

        // Hapus jawaban yang benar sebelum dikirim ke frontend
        foreach ($soalList as &$soal) {
            unset($soal['jawaban_yang_benar']);
        }

        return response()->json([
            'room' => $room,
            'soal' => $soalList,
            'lomba' => $room->lomba,
        ]);
    }

    public function updateJawaban(Request $request, $id)
    {
        $room = RoomTes::where('id', $id)
            ->firstOrFail();

        // Simpan jawaban sebagai array langsung ke database
        $room->update([
            'soal_terjawab' => $request->input('jawaban', []),
        ]);

        return response()->json(['message' => 'Jawaban berhasil diperbarui']);
    }
}
