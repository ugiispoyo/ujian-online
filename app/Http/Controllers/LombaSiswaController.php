<?php

namespace App\Http\Controllers;

use App\Models\Lomba;
use App\Models\RoomTes;
use App\Models\Soal;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Sertifikat;

use Intervention\Image\ImageManager;

class LombaSiswaController extends Controller
{
    public function index()
    {
        // Ambil semua data lomba dari database
        $lombas = Lomba::paginate(10);
        return view('dashboard.daftar-lomba', compact('lombas'));
    }

    public function list()
    {
        $userId = Auth::id();

        // Ambil event lomba yang sudah didaftarkan oleh user dan telah terverifikasi
        $events = Lomba::whereIn('id', function ($query) use ($userId) {
            $query->select('id_lomba')
                ->from('pendaftaran_lomba')
                ->where('id_siswa', $userId)
                ->where('status', 'verified'); // Hanya yang terverifikasi
        })
            ->orderBy('waktu_lomba', 'asc')
            ->get();

        // Ambil room ujian untuk user yang sedang login
        $userRooms = RoomTes::whereIn('id_lomba', $events->pluck('id'))
            ->where('id_siswa', $userId)
            ->get()
            ->mapWithKeys(function ($room) {
                return [$room->id_lomba => $room]; // Ubah menjadi key-value pair id_lomba => room
            });

        return view('dashboard.list-event', compact('events', 'userRooms'));
    }

    public function detail($id)
    {
        $userId = Auth::id();

        // Ambil data lomba
        $lomba = Lomba::findOrFail($id);

        // Ambil data soal dari tabel soal
        $soalData = Soal::where('id_lomba', $id)->first();

        // Ambil data room ujian pengguna saat ini
        $userRoom = RoomTes::where('id_lomba', $id)
            ->where('id_siswa', $userId)
            ->first();

        if (!$userRoom) {
            return redirect()->route('dashboard')->with('error', 'Anda belum mengikuti lomba ini.');
        }

        // Decode soal dan jawaban dari JSON ke array
        $soalLomba = is_string($soalData->soal) ? json_decode($soalData->soal, true) : $soalData->soal;
        $soalTerjawab = is_string($userRoom->soal_terjawab) ? json_decode($userRoom->soal_terjawab, true) : $userRoom->soal_terjawab;

        return view('dashboard.detail-event', compact('lomba', 'soalLomba', 'soalTerjawab', 'userRoom'));
    }


    public function downloadSertifikat($id)
    {
        $sertifikat = Sertifikat::findOrFail($id);
        $siswa = User::find($sertifikat->id_siswa);
        $lomba = Lomba::find($sertifikat->id_lomba);

        // Background sertifikat
        $manager = new ImageManager(['driver' => 'gd']); // Pilih driver 'gd' atau 'imagick'
        $img = $manager->make(public_path('images/bg-sertifikat.jpg'))->resize(600, 400);
        $img->save(public_path('images/resized-sample.jpg'));

        // Tambahkan teks ke sertifikat
        // Nama Lomba - Posisikan di tengah atas
        $img->text($lomba->nama_lomba, 300, 80, function ($font) {
            $font->size(60); // Ukuran teks lebih besar
            $font->color('#000');
            $font->align('center');
            $font->valign('middle');
        });

        // Nama Siswa - Posisikan di tengah gambar
        $img->text($siswa->name, 300, 200, function ($font) {
            $font->size(70); // Lebih besar untuk nama siswa
            $font->color('#000');
            $font->align('center');
            $font->valign('middle');
        });

        // Waktu Lomba - Posisikan di bawah nama siswa
        $img->text('Waktu Lomba: ' . \Carbon\Carbon::parse($lomba->waktu_lomba)->format('d M Y H:i'), 300, 320, function ($font) {
            $font->size(50); // Lebih besar untuk keterbacaan
            $font->color('#000');
            $font->align('center');
            $font->valign('middle');
        });



        // Simpan dan download gambar
        $fileName = "sertifikat_{$siswa->name}.jpg";
        $img->save(public_path("sertifikat/{$fileName}"));

        return response()->download(public_path("sertifikat/{$fileName}"));
    }
}
