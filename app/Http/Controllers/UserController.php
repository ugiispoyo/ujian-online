<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{

    public function index(Request $request)
    {
        $query = User::query();

        // Filter berdasarkan nama jika ada input pencarian
        if ($request->has('name') && !empty($request->name)) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        // Paginate hasil query dengan 10 item per halaman
        $users = $query->paginate(10);

        return view('dashboard.admin.users.index', compact('users'));
    }

    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);

        // Ubah status antara 'active' dan 'block'
        $user->status = $user->status === 'active' ? 'block' : 'active';
        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'Status pengguna berhasil diperbarui.');
    }
}
