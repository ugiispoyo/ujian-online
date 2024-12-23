<?php

namespace App\Http\Controllers;

use App\Models\Lomba;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LombaController extends Controller
{
    public function index()
    {
        $lomba = Lomba::all();
        return view('dashboard.admin.lomba.index', compact('lomba'));
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
            'waktu_lomba' => 'required|date',
        ]);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('gambar-lomba', 'public');
        }

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
            'waktu_lomba' => 'required|date',
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
}
