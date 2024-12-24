@extends('layouts.dashboard')

@section('content')
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-6">Status Pembayaran Lomba</h1>

        @if ($pendaftaranLombas->isEmpty())
            <p class="text-gray-500">Belum ada pendaftaran lomba yang aktif.</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md">
                    <thead>
                        <tr class="bg-gray-100 text-gray-700 uppercase text-sm">
                            <th class="px-6 py-3 border">Nama Lomba</th>
                            <th class="px-6 py-3 border">Waktu Lomba</th>
                            <th class="px-6 py-3 border">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pendaftaranLombas as $pendaftaran)
                            <tr class="text-gray-700 border">
                                <td class="px-6 py-4">{{ $pendaftaran->lomba->nama_lomba }}</td>
                                <td class="px-6 py-4">
                                    {{ \Carbon\Carbon::parse($pendaftaran->lomba->waktu_lomba)->locale('id')->translatedFormat('l, d F Y H:i') }}
                                </td>
                                <td class="px-6 py-4">
                                    @if ($pendaftaran->status === 'verified')
                                        <span class="text-green-600 font-bold">Terkonfirmasi</span>
                                    @else
                                        <span class="text-red-600 font-bold">Belum Terkonfirmasi</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
