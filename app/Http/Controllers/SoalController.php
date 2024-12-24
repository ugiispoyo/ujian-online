<?php

namespace App\Http\Controllers;

use App\Models\Soal;
use App\Models\Lomba;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SoalController extends Controller
{
    public function create()
    {
        $lombas = Lomba::all();
        return view('dashboard.admin.soal.create', compact('lombas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_lomba' => 'required|exists:lomba,id',
            'soal' => 'required|array',
        ]);

        // Cari soal berdasarkan id_lomba
        $existingSoal = Soal::where('id_lomba', $validated['id_lomba'])->first();

        if ($existingSoal) {
            // Jika sudah ada, tambahkan soal baru ke kolom JSON 'soal'
            $currentSoals = $existingSoal->soal; // Decode JSON dari database
            $currentSoals[] = $validated['soal']; // Tambahkan soal baru ke array

            // Update kolom soal dengan data yang diperbarui
            $existingSoal->update([
                'soal' => $currentSoals,
            ]);
        } else {
            // Jika belum ada, buat record baru
            Soal::create([
                'id_lomba' => $validated['id_lomba'],
                'soal' => [$validated['soal']], // Simpan soal sebagai array
            ]);
        }

        return response()->json(['message' => 'Soal berhasil disimpan.'], 201);
    }


    public function getByLomba($id_lomba)
    {
        $soals = Soal::where('id_lomba', $id_lomba)->get();

        return response()->json($soals);
    }
}
