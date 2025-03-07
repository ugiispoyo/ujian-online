<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Lomba;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\RoomTes;

class LombaController extends Controller
{
    public function index()
    {
        $lombas = Lomba::paginate(10); // Menampilkan 10 lomba per halaman
        return view('dashboard.admin.lomba.index', compact('lombas'));
    }


    public function create()
    {
        return view('dashboard.admin.lomba.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lomba' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'gambar' => 'nullable|image|max:2048',
            'durasi' => 'required|numeric|min:1',
            'waktu_lomba' => ['required', 'date', 'after_or_equal:' . Carbon::tomorrow()->toDateString()], // Minimal besok
            'harga_pendaftaran' => 'required|numeric|min:0',
        ], [
            'waktu_lomba.after_or_equal' => 'Tanggal lomba harus minimal besok.',
        ]);


        // Simpan gambar jika ada
        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('gambar-lomba', 'public');
        }

        // Tambahkan status dengan default `not_started` jika tidak disediakan
        $validated['status'] = $request->input('status', 'not_started');

        Lomba::create($validated);

        return redirect()->route('admin.lomba')->with('success', 'Lomba berhasil dibuat.');
    }


    public function edit($id)
    {
        $lomba = Lomba::findOrFail($id);
        return view('dashboard.admin.lomba.edit', compact('lomba'));
    }

    public function update(Request $request, $id)
    {
        $lomba = Lomba::findOrFail($id);

        $validated = $request->validate([
            'nama_lomba' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'gambar' => 'nullable|image|max:2048',
            'durasi' => 'required|numeric|min:1',
            'waktu_lomba' => ['required', 'date', 'after_or_equal:' . Carbon::tomorrow()->toDateString()], // Minimal besok
            'harga_pendaftaran' => 'required|numeric|min:0',
        ], [
            'waktu_lomba.after_or_equal' => 'Tanggal lomba harus minimal besok.',
        ]);


        if ($request->hasFile('gambar')) {
            if ($lomba->gambar) {
                Storage::disk('public')->delete($lomba->gambar);
            }
            $validated['gambar'] = $request->file('gambar')->store('gambar-lomba', 'public');
        }

        $lomba->update($validated);

        return redirect()->route('admin.lomba')->with('success', 'Lomba berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $lomba = Lomba::findOrFail($id);

        if ($lomba->gambar) {
            Storage::disk('public')->delete($lomba->gambar);
        }

        $lomba->delete();

        return redirect()->route('admin.lomba')->with('success', 'Lomba berhasil dihapus.');
    }

    public function startLomba($id)
    {
        $lomba = Lomba::findOrFail($id);

        if ($lomba->status === 'not_started') {
            $lomba->update(['status' => 'in_progress']);
            return redirect()->route('admin.lomba')->with('success', 'Lomba berhasil dimulai.');
        }

        return redirect()->route('admin.lomba')->with('error', 'Lomba tidak bisa dimulai.');
    }

    public function monitoring($id)
    {
        $lomba = Lomba::with('soal')->findOrFail($id);
        $roomTes = RoomTes::where('id_lomba', $id)->with('siswa')->get();

        return view('dashboard.admin.lomba.monitoring', compact('lomba', 'roomTes'));
    }

    public function complete($id)
    {
        $lomba = Lomba::findOrFail($id);
    
        // Pastikan lomba sedang berlangsung sebelum bisa diselesaikan
        if ($lomba->status !== 'in_progress') {
            return redirect()->route('admin.lomba')->with('error', 'Lomba tidak bisa diselesaikan karena belum dimulai.');
        }
    
        // Update status lomba menjadi completed
        $lomba->update(['status' => 'completed']);
    
        // Update semua room_tes yang terkait dengan lomba ini menjadi selesai
        RoomTes::where('id_lomba', $id)->update(['status' => 'selesai']);
    
        return redirect()->route('admin.lomba')->with('success', 'Lomba telah berhasil diselesaikan dan semua room ujian telah diupdate.');
    }
    
}
