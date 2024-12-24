<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    public function uploadImage(Request $request)
    {
        $validated = $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('file')) {
            // Simpan file di storage/public/bank-soal
            $path = $request->file('file')->store('bank-soal', 'public');

            // URL lengkap untuk file
            $url = Storage::url($path);

            return response()->json([
                'url' => asset($url), // URL yang dapat diakses dari browser
                'message' => 'Gambar berhasil diunggah.',
            ], 200);
        }

        return response()->json([
            'message' => 'Gagal mengunggah gambar.',
        ], 400);
    }
}
