<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'SIMADIK - Sistem Informasi Manajemen Akademik & Pendidikan')</title>
    <meta name="description" content="SIMADIK - Sistem Informasi Manajemen Akademik & Pendidikan">
    <link rel="icon" type="image/webp" href="{{ asset('assets/img/icon-web.webp') }}">
    {{-- Bootstrap Icons (hanya font ikon, bukan Bootstrap CSS). Hapus baris ini jika sudah di-import di app.css --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>

<body class="flex min-h-screen flex-col bg-gray-50 text-gray-800 antialiased dark:bg-gray-900 dark:text-gray-100">

    {{-- Navbar --}}
    <x-navbar fixed>
        <x-slot:brand>
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <span
                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white p-1 shadow-sm ring-1 ring-gray-200">
                    <img src="{{ asset('assets/img/icon-web.webp') }}" alt="Logo Tut Wuri Handayani"
                        class="h-full w-full object-contain">
                </span>
                <span class="flex flex-col leading-tight">
                    <span class="text-lg font-extrabold text-blue-600">SIMADIK</span>
                    <span class="hidden text-[11px] font-medium text-gray-500 dark:text-gray-400 sm:block">
                        Disdikbud Kabupaten Lahat
                    </span>
                </span>
            </a>
        </x-slot:brand>

        <x-slot:menu>
            <a href="{{ route('home') }}#beranda"
                class="rounded-md px-3 py-2 text-sm font-medium hover:bg-gray-100 hover:text-blue-600 dark:hover:bg-gray-700">Beranda</a>
            <a href="{{ route('home') }}#statistik"
                class="rounded-md px-3 py-2 text-sm font-medium hover:bg-gray-100 hover:text-blue-600 dark:hover:bg-gray-700">Statistik</a>
            <a href="{{ route('home') }}#fitur"
                class="rounded-md px-3 py-2 text-sm font-medium hover:bg-gray-100 hover:text-blue-600 dark:hover:bg-gray-700">Fitur</a>
        </x-slot:menu>

        <x-slot:actions>
            <x-button href="{{ route('login') }}" size="sm">Masuk</x-button>
        </x-slot:actions>
    </x-navbar>

    {{-- Konten (pt-16 mengimbangi navbar fixed) --}}
    <main class="min-w-0 flex-1 pt-16">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-blue-950 text-blue-100">
        <div class="mx-auto grid max-w-6xl gap-8 px-4 py-10 sm:grid-cols-2 lg:grid-cols-3">
            <div>
                <a href="{{ route('home') }}" class="flex items-center gap-3">
                    <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-white p-1.5">
                        <img src="{{ asset('assets/img/icon-web.webp') }}" alt="Logo Tut Wuri Handayani"
                            class="h-full w-full object-contain">
                    </span>
                    <span class="text-xl font-extrabold text-white">SIMADIK</span>
                </a>
                <p class="mt-4 text-sm text-blue-200">
                    Sistem Informasi Manajemen Akademik &amp; Pendidikan.
                </p>
                <p class="mt-1 text-sm text-blue-200">
                    Dinas Pendidikan dan Kebudayaan Kabupaten Lahat
                </p>
            </div>

            <div>
                <h3 class="text-sm font-semibold uppercase tracking-wide text-white">Navigasi</h3>
                <ul class="mt-3 space-y-2 text-sm text-blue-200">
                    <li><a href="{{ route('home') }}#beranda" class="hover:text-white">Beranda</a></li>
                    <li><a href="{{ route('home') }}#statistik" class="hover:text-white">Statistik</a></li>
                    <li><a href="{{ route('home') }}#fitur" class="hover:text-white">Fitur</a></li>
                    <li><a href="{{ route('login') }}" class="hover:text-white">Masuk</a></li>
                </ul>
            </div>

            <div class="sm:col-span-2 lg:col-span-1">
                <h3 class="text-sm font-semibold uppercase tracking-wide text-white">Tentang</h3>
                <p class="mt-3 text-sm text-blue-200">
                    Satu aplikasi untuk mengelola data sekolah, siswa, dan pegawai secara terpusat.
                </p>
            </div>
        </div>

        <div class="border-t border-white/10 py-4 text-center text-xs text-blue-300">
            &copy; {{ date('Y') }} SIMADIK. Seluruh hak cipta dilindungi.
        </div>
    </footer>

    @stack('scripts')
</body>

</html>
