<?php

namespace App\Http\Controllers;

use App\Models\Lomba;
use App\Models\PendaftaranLomba;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PendaftaranLombaController extends Controller
{
    public function index(Request $request)
    {
        $query = PendaftaranLomba::with(['lomba', 'siswa']);

        // Filter berdasarkan lomba
        if ($request->filled('filter_lomba')) {
            $query->where('id_lomba', $request->filter_lomba);
        }

        // Pencarian nama siswa atau nama lomba
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('siswa', function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%');
            })->orWhereHas('lomba', function ($q) use ($search) {
                $q->where('nama_lomba', 'like', '%' . $search . '%');
            });
        }

        $pendaftaran = $query->paginate(10);
        $lombas = Lomba::all(); // Untuk filter lomba

        return view('dashboard.admin.lomba.list-daftar', compact('pendaftaran', 'lombas'));
    }

    public function confirm($id)
    {
        $pendaftaran = PendaftaranLomba::findOrFail($id);
        $pendaftaran->update(['status' => 'verified']);

        return redirect()->route('admin.pendaftaran-lomba.index')->with('success', 'Pembayaran berhasil dikonfirmasi.');
    }


    public function create($id)
    {
        $lomba = Lomba::findOrFail($id);
        return view('dashboard.pendaftaran', compact('lomba'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'id_lomba' => 'required|exists:lomba,id',
            'bukti_transfer' => 'required|image|max:2048',
            'tanggal_transfer' => 'required|date',
        ]);

        // Periksa apakah siswa sudah mendaftar untuk lomba ini
        $existingPendaftaran = PendaftaranLomba::where('id_lomba', $validated['id_lomba'])
            ->where('id_siswa', Auth::id())
            ->whereNotIn('status', ['rejected'])
            ->first();

        // Jika sudah pernah mendaftar dan status tidak rejected, tampilkan error
        if ($existingPendaftaran) {
            return redirect()->back()->withErrors([
                'id_lomba' => 'Anda sudah mendaftar lomba ini dan statusnya tidak memungkinkan untuk mendaftar lagi.',
            ])->withInput();
        }

        // Simpan file bukti transfer
        if ($request->hasFile('bukti_transfer')) {
            $validated['bukti_transfer'] = $request->file('bukti_transfer')->store('bukti-transfer', 'public');
        }

        // Simpan data pendaftaran baru
        PendaftaranLomba::create([
            'id_lomba' => $validated['id_lomba'],
            'id_siswa' => Auth::id(),
            'bukti_transfer' => $validated['bukti_transfer'],
            'tanggal_transfer' => $validated['tanggal_transfer'],
            'status' => 'unverified',
        ]);

        return redirect()->route('status-pembayaran')->with('success', 'Pendaftaran lomba berhasil dilakukan. Harap menunggu verifikasi.');
    }
}
