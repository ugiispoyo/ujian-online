<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lomba;
use App\Models\RoomTes;
use Illuminate\Support\Facades\Auth;

class UjianController extends Controller
{
    public function ujianSelesai($id)
    {
        $userId = Auth::id();
        
        // Cari Room Ujian berdasarkan id dan user
        $room = RoomTes::where('id', $id)->where('id_siswa', $userId)->firstOrFail();
        $lomba = Lomba::findOrFail($room->id_lomba);

        return view('dashboard.ujian-selesai', compact('lomba', 'room'));
    }
}
