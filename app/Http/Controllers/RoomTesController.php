<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RoomTes;

class RoomTesController extends Controller
{
    /**
     * Mendapatkan data Room Tes
     */
    public function getRoom($id)
    {
        $room = RoomTes::with(['lomba', 'siswa'])->findOrFail($id);
        $soal_lomba = $room->lomba->soal ?? [];

        return response()->json([
            'room' => $room,
            'soal' => $soal_lomba,
        ]);
    }

    /**
     * Menyimpan Progres Soal Terjawab
     */
    public function saveProgress(Request $request, $id)
    {
        $request->validate([
            'soal_terjawab' => 'required|array',
        ]);

        $room = RoomTes::findOrFail($id);

        if ($room->status !== 'selesai') {
            $room->update([
                'soal_terjawab' => $request->soal_terjawab,
                'status' => 'draft',
            ]);

            return response()->json([
                'message' => 'Progres tes berhasil disimpan.',
                'data' => $room
            ]);
        } else {
            return response()->json(['message' => 'Tes telah selesai.'], 400);
        }
    }

    /**
     * Menghitung Nilai dan Submit Tes
     */
    public function submitTes(Request $request, $id)
    {
        $room = RoomTes::with('lomba')->findOrFail($id);
        $soal_terjawab = $room->soal_terjawab ?? [];
        $soal_asli = $room->lomba->soal ?? [];

        $nilai = 0;

        foreach ($soal_asli as $soal) {
            if (
                isset($soal_terjawab[$soal['id']]) &&
                $soal_terjawab[$soal['id']] === $soal['jawaban_yang_benar']
            ) {
                $nilai++;
            }
        }

        $room->update([
            'nilai' => $nilai,
            'status' => 'selesai',
        ]);

        return response()->json([
            'message' => 'Tes berhasil disubmit.',
            'nilai' => $nilai,
            'data' => $room
        ]);
    }
}
