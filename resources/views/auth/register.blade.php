@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
    <h2 class="text-2xl font-bold mb-6 text-center">Register</h2>
    <form method="POST" action="/api/register" class="space-y-4">
        @csrf
        <div>
            <label for="name" class="block text-sm font-medium">Nama</label>
            <input type="text" id="name" name="name" placeholder="Nama Lengkap"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
        </div>
        <div>
            <label for="nik" class="block text-sm font-medium">NIK</label>
            <input type="text" id="nik" name="nik" placeholder="Nomor Induk Kependudukan"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
        </div>
        <div>
            <label for="jenis_kelamin" class="block text-sm font-medium">Jenis Kelamin</label>
            <select id="jenis_kelamin" name="jenis_kelamin"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                <option value="Laki-laki">Laki-laki</option>
                <option value="Perempuan">Perempuan</option>
            </select>
        </div>
        <div>
            <label for="tanggal_lahir" class="block text-sm font-medium">Tanggal Lahir</label>
            <input type="date" id="tanggal_lahir" name="tanggal_lahir"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
        </div>
        <div>
            <label for="alamat" class="block text-sm font-medium">Alamat</label>
            <textarea id="alamat" name="alamat" rows="3" placeholder="Alamat"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"></textarea>
        </div>
        <div>
            <label for="sekolah" class="block text-sm font-medium">Sekolah</label>
            <input type="text" id="sekolah" name="sekolah" placeholder="Nama Sekolah"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
        </div>
        <div>
            <label for="kelas" class="block text-sm font-medium">Kelas</label>
            <input type="text" id="kelas" name="kelas" placeholder="Kelas"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
        </div>
        <div>
            <label for="email" class="block text-sm font-medium">Email</label>
            <input type="email" id="email" name="email" placeholder="Email"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
        </div>
        <div>
            <label for="password" class="block text-sm font-medium">Password</label>
            <input type="password" id="password" name="password" placeholder="Password"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
        </div>
        <div>
            <label for="password_confirmation" class="block text-sm font-medium">Konfirmasi Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation"
                placeholder="Konfirmasi Password"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
        </div>
        <button type="submit"
            class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
            Register
        </button>
    </form>
</div>
@endsection
