<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Ujian Online App' }}</title>
    @vite('resources/css/app.css')
    <script src="{{ asset('node_modules/flowbite/dist/flowbite.min.js') }}" defer></script>
</head>

<body class="bg-gray-100 font-sans antialiased">
    <!-- Navbar -->
    <nav class="bg-white border-gray-200 px-4 py-2.5">
        <div class="container flex flex-wrap items-center justify-between mx-auto">
            <a href="/" class="flex items-center">
                <span class="self-center text-xl font-semibold whitespace-nowrap">Ujian Online</span>
            </a>
            <div class="flex md:order-2">
                <a href="/login"
                    class="text-gray-700 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 font-medium rounded-lg text-sm px-4 py-2 mr-2">Login</a>
                <a href="/register"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2">Register</a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mx-auto mt-8 flex justify-center">
        @yield('content')
    </div>
</body>

</html>
