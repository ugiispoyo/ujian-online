<?php

namespace App\Http\Controllers;

use App\Models\Lomba;

class LombaSiswaController extends Controller
{
    public function index()
    {
        // Ambil semua data lomba dari database
        $lombas = Lomba::paginate(10);
        return view('dashboard.daftar-lomba', compact('lombas'));
    }
}
