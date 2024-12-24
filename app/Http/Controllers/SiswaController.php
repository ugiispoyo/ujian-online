<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\PendaftaranLomba;
use Carbon\Carbon;

class SiswaController extends Controller
{
    // Menampilkan form edit profile
    public function edit()
    {
        $user = Auth::user(); // Mendapatkan data siswa yang sedang login
        return view('dashboard.edit-profile', compact('user'));
    }

    // Menyimpan perubahan data profile
    public function update(Request $request)
    {
        $user = User::find(Auth::id());

        // Validasi input
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'nik' => 'required|numeric|unique:users,nik,' . $user->id,
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string',
            'sekolah' => 'required|string',
            'kelas' => 'required|string',
        ]);

        try {
            // Update data siswa
            $user->update($validatedData);

            // Kembalikan ke halaman edit dengan pesan sukses
            return back()->with('success', 'Data diri berhasil diperbarui.');
        } catch (\Exception $e) {
            // Kembalikan ke halaman edit dengan pesan error
            return back()->with('error', 'Terjadi kesalahan saat menyimpan data.');
        }
    }

    public function daftarPembayaran()
    {
        $pendaftaranLombas = PendaftaranLomba::with('lomba')
            ->where('id_siswa', Auth::user()->id)
            ->whereHas('lomba', function ($query) {
                $query->where('waktu_lomba', '>', Carbon::now());
            })
            ->get();

        return view('dashboard.status-pembayaran', compact('pendaftaranLombas'));
    }
}
