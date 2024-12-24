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

        Soal::create([
            'id_lomba' => $validated['id_lomba'],
            'soal' => $validated['soal'],
        ]);

        return response()->json(['message' => 'Soal berhasil disimpan.'], 201);
    }

    public function getByLomba($id_lomba)
    {
        $soals = Soal::where('id_lomba', $id_lomba)->get();

        return response()->json($soals);
    }
}
