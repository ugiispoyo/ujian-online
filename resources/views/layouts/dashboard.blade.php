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

    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-gray-800 text-white shadow-md min-h-screen">
            <div class="p-6">
                <h2 class="text-2xl font-semibold">My App</h2>
                <ul class="mt-6 space-y-2">
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
                </ul>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Navbar -->
            <nav class="bg-white shadow p-4">
                <div class="container mx-auto flex justify-between items-center">
                    <h1 class="text-lg font-bold">Dashboard</h1>
                    <div class="flex items-center space-x-4">
                        <span class="text-gray-900 font-bold">{{ auth()->user()->name }}</span>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="text-gray-800 px-4 py-2 rounded-lg">Logout</button>
                        </form>
                    </div>
                </div>
            </nav>

            <!-- Page Content -->
            <main class="p-6 flex-1">
                @yield('content')
            </main>
        </div>
    </div>

</body>

</html>
