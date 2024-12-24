<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Dashboard' }}</title>
    @vite('resources/css/app.css')
    <script src="{{ asset('node_modules/flowbite/dist/flowbite.min.js') }}" defer></script>
</head>

<body class="bg-gray-100 font-sans antialiased">

    <div class="flex h-screen relative">
        <!-- Sidebar -->
        <aside class="bg-gray-800 text-white shadow-md min-h-screen h-full w-full max-w-[20%]">
            <div class="p-6">
                <h2 class="text-2xl font-semibold">Dashboard</h2>
                <ul class="mt-6 space-y-2">
                    @if (auth()->guard('admin')->check())
                        <!-- Menu untuk Admin -->
                        <li>
                            <a href="{{ route('dashboard-admin') }}"
                                class="flex items-center px-4 py-2 text-gray-300 hover:bg-gray-700 rounded-lg">
                                Dashboard Admin
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.lomba') }}"
                                class="flex items-center px-4 py-2 text-gray-300 hover:bg-gray-700 rounded-lg">
                                List Lomba
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.pendaftaran-lomba.index') }}"
                                class="flex items-center px-4 py-2 text-gray-300 hover:bg-gray-700 rounded-lg">
                                Konfirmasi Pembayaran
                            </a>
                        </li>
                    @elseif (auth()->check())
                        <!-- Menu untuk Siswa -->
                        <li>
                            <a href="{{ route('dashboard') }}"
                                class="flex items-center px-4 py-2 text-gray-300 hover:bg-gray-700 rounded-lg">
                                Dashboard
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('daftar-lomba') }}"
                                class="flex items-center px-4 py-2 text-gray-300 hover:bg-gray-700 rounded-lg">
                                Daftar Lomba
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('status-pembayaran') }}"
                                class="flex items-center px-4 py-2 text-gray-300 hover:bg-gray-700 rounded-lg">
                                Status Pembayaran Lomba
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col w-full">
            <!-- Navbar -->
            <nav class="bg-white shadow p-4">
                <div class="container mx-auto flex justify-end items-center">
                    <div class="relative">
                        <button id="dropdownUserButton" data-dropdown-toggle="dropdownUser"
                            class="text-gray-800 font-bold focus:outline-none">
                            {{ auth()->user()->name }}
                        </button>
                        <div id="dropdownUser" class="hidden absolute right-0 z-10 w-44 bg-white rounded shadow dark:bg-gray-700">
                            <ul class="py-1 text-sm text-gray-700 dark:text-gray-200">
                                @if (auth()->guard('admin')->check())
                                    <li>
                                        <a href="{{ route('dashboard-admin') }}"
                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                            Dashboard
                                        </a>
                                    </li>
                                @else
                                    <li>
                                        <a href="{{ route('edit-profile') }}"
                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                            Edit Profile
                                        </a>
                                    </li>
                                @endif
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="w-full text-left block px-4 pt-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                            Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Content -->
            <main class="p-6 flex-1 overflow-auto">
                @yield('content')
            </main>
        </div>
    </div>

</body>

<script>
    // Hilangkan alert sukses setelah 5 detik
    setTimeout(() => {
        const successAlert = document.getElementById('success-alert');
        if (successAlert) {
            successAlert.style.transition = 'opacity 0.5s ease';
            successAlert.style.opacity = '0';
            setTimeout(() => successAlert.remove(), 500); // Hapus elemen setelah animasi selesai
        }
    }, 5000);

    // Hilangkan alert error setelah 5 detik
    setTimeout(() => {
        const errorAlert = document.getElementById('error-alert');
        if (errorAlert) {
            errorAlert.style.transition = 'opacity 0.5s ease';
            errorAlert.style.opacity = '0';
            setTimeout(() => errorAlert.remove(), 500); // Hapus elemen setelah animasi selesai
        }
    }, 5000);
</script>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const dropdownButton = document.getElementById("dropdownUserButton");
        const dropdownMenu = document.getElementById("dropdownUser");

        if (dropdownButton) {
            dropdownButton.addEventListener("click", () => {
                dropdownMenu.classList.toggle("hidden");
            });
        }
    });
</script>

</html>
