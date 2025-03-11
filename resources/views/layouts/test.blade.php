<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Dashboard' }}</title>
    @if (app()->environment('production'))
        {{-- Load file CSS --}}
        @foreach (load_vite_assets()['css'] as $css)
            <link rel="stylesheet" href="{{ $css }}">
        @endforeach

        {{-- Load file JS --}}
        @foreach (load_vite_assets()['js'] as $js)
            <script type="module" src="{{ $js }}"></script>
        @endforeach
    @else
        @vite('resources/css/app.css')
        <script src="{{ asset('node_modules/flowbite/dist/flowbite.min.js') }}" defer></script>
    @endif

</head>

<body class="bg-gray-100 font-sans antialiased">

    <div class="flex h-screen relative">

        <!-- Main Content -->
        <div class="flex-1 flex flex-col  w-full max-w-[100%]">
            <!-- Navbar -->
            <nav class="bg-white shadow p-4">
                <div class="container mx-auto flex justify-end items-center">
                    <div class="relative">
                        <button id="dropdownUserButton" data-dropdown-toggle="dropdownUser"
                            class="text-gray-800 font-bold focus:outline-none">
                            {{ auth()->user()->name }}
                        </button>
                        <div id="dropdownUser"
                            class="hidden absolute right-0 z-10 w-44 bg-white rounded shadow dark:bg-gray-700">
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

            <!-- Jitsi Meet Video Call -->
            {{-- <div class="border rounded-lg overflow-hidden shadow-lg max-w-[300px] absolute">
                <iframe src="https://meet.jit.si/{{ $room->id_lomba }}" allow="camera; microphone; fullscreen; display-capture"
                    class="h-96">
                </iframe>
            </div> --}}


            <!-- Page Content -->
            <main class="p-6 flex-1 overflow-auto">
                @if ($room->id)
                    <div id="root-test"></div>
                @endif
            </main>
        </div>
    </div>

</body>

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

@if (!app()->environment('production'))
    @viteReactRefresh
    @vite('resources/js/room-ujian/tes.jsx')
@endif

</html>
