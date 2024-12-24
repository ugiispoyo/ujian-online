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
        // Ambil semua lomba
        $allLombas = Lomba::all();

        // Filter lomba yang belum memiliki soal
        $lombasWithoutSoal = $allLombas->filter(function ($lomba) {
            return !\App\Models\Soal::where('id_lomba', $lomba->id)->exists();
        });

        // Kirim data yang sudah difilter ke view
        return view('dashboard.admin.soal.create', [
            'lombas' => $lombasWithoutSoal
        ]);
    }

    public function edit(Request $request)
    {
        // Ambil id_lomba dari query parameter
        $id_lomba = $request->query('id_lomba');

        // Validasi apakah id_lomba ada
        if (!$id_lomba) {
            abort(404, 'Parameter id_lomba tidak ditemukan.');
        }

        // Cari data lomba berdasarkan id
        $lomba = Lomba::findOrFail($id_lomba);

        return view('dashboard.admin.soal.edit', compact('lomba'));
    }


    public function index()
    {
        $soals = Soal::with('lomba')->paginate(10); // Relasi dengan tabel lomba
        return view('dashboard.admin.soal.index', compact('soals'));
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

    public function deleteSoal(Request $request)
    {
        $validated = $request->validate([
            'id_lomba' => 'required|exists:lomba,id',
            'soal' => 'array',
        ]);

        // Cari soal berdasarkan id_lomba
        $existingSoal = Soal::where('id_lomba', $validated['id_lomba'])->first();

        if ($existingSoal) {

            // Update kolom soal dengan data yang diperbarui
            $existingSoal->update([
                'soal' => $validated['soal'],
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
