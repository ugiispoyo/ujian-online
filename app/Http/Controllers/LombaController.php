<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Lomba;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Models\RoomTes;
use App\Models\Soal;
use App\Models\Sertifikat;

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

        // Ambil soal dari tabel soal yang memiliki id_lomba yang sesuai
        $soalData = Soal::where('id_lomba', $id)->first();

        if (!$soalData || empty($soalData->soal)) {
            return redirect()->route('admin.lomba')->with('error', 'Tidak ada soal untuk lomba ini.');
        }

        // Pastikan soal disimpan sebagai array
        $soalLomba = is_array($soalData->soal) ? $soalData->soal : [];

        // Buat mapping soal berdasarkan ID untuk pencocokan lebih cepat
        $soalMap = [];
        foreach ($soalLomba as $soal) {
            if (isset($soal['id'], $soal['jawaban_yang_benar'])) {
                $soalMap[$soal['id']] = $soal['jawaban_yang_benar'];
            }
        }

        // Ambil semua room_tes yang terkait dengan lomba ini
        $rooms = RoomTes::where('id_lomba', $id)->get();

        foreach ($rooms as $room) {
            // Ambil soal yang sudah dijawab
            $soalTerjawab = is_array($room->soal_terjawab) ? $room->soal_terjawab : json_decode($room->soal_terjawab, true);

            if (!is_array($soalTerjawab)) {
                $soalTerjawab = [];
            }

            $nilai = 0; // Reset nilai setiap peserta

            // Cek jawaban peserta berdasarkan ID soal
            foreach ($soalTerjawab as $jawaban) {
                if (isset($jawaban['id'], $jawaban['jawaban_di_pilih']) && isset($soalMap[$jawaban['id']])) {
                    if ($jawaban['jawaban_di_pilih'] === $soalMap[$jawaban['id']]) {
                        $nilai += 1; // Tambah nilai jika jawaban benar
                    }
                }
            }

            // Debugging log untuk memastikan nilai tersimpan
            Log::info("Nilai untuk siswa {$room->id_siswa} : {$nilai}");

            // Update nilai dan status room_tes untuk setiap peserta
            RoomTes::where('id', $room->id)->update([
                'status' => 'selesai',
                'nilai' => $nilai, // Jumlah jawaban yang benar langsung disimpan
                'waktu_selesai' => Carbon::now()
            ]);
        }

        return redirect()->route('admin.lomba')->with('success', 'Lomba telah berhasil diselesaikan, semua room ujian telah diperiksa dan dinilai.');
    }

    public function detail($id, Request $request)
    {
        $lomba = Lomba::findOrFail($id);

        // Ambil soal dari tabel soal yang memiliki id_lomba yang sesuai
        $soalData = Soal::where('id_lomba', $id)->first();
        $soalLomba = $soalData ? $soalData->soal : []; // Pastikan soal berbentuk array

        // Query RoomTes berdasarkan lomba
        $query = RoomTes::where('id_lomba', $id)
            ->with('siswa') // Ambil relasi ke siswa
            ->orderBy('nilai', $request->get('sort_nilai') && $request->get('sort_nilai') !== "" ? $request->get('sort_nilai') : "desc"); // Default sorting: terbesar

        // Filter berdasarkan nama peserta
        if ($request->filled('nama')) {
            $query->whereHas('siswa', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->nama . '%');
            });
        }

        // Ambil peserta dengan pagination
        $peserta = $query->paginate(10);

        return view('dashboard.admin.lomba.detail', compact('lomba', 'peserta', 'soalLomba'));
    }

    public function generateSertifikat($id)
    {
        $lomba = Lomba::findOrFail($id);
        $rooms = RoomTes::where('id_lomba', $id)->get();

        foreach ($rooms as $room) {
            // Cek apakah sertifikat sudah dibuat
            $existingSertifikat = Sertifikat::where('id_room', $room->id)->first();
            if (!$existingSertifikat) {
                Sertifikat::create([
                    'id_lomba' => $id,
                    'id_room' => $room->id,
                    'id_siswa' => $room->id_siswa,
                    'nilai' => $room->nilai,
                ]);
            }
        }

        return redirect()->route('admin.lomba.detail', $id)->with('success', 'Sertifikat berhasil dibuat untuk semua peserta.');
    }
}
