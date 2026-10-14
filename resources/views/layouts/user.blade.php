<!doctype html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIMANDIK-SMP - @yield('title')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    {{-- Terapkan tema sebelum halaman dirender agar tidak berkedip (flash) --}}
    <script>
        (function() {
            try {
                var tersimpan = localStorage.getItem('theme');
                var gelap = tersimpan ? tersimpan === 'dark' : window.matchMedia('(prefers-color-scheme: dark)')
                    .matches;
                document.documentElement.classList.toggle('dark', gelap);
            } catch (e) {}
        })();
    </script>
    <style>
        :root {
            color-scheme: light;
        }

        :root.dark {
            color-scheme: dark;
        }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 text-gray-800 dark:bg-gray-900 dark:text-gray-100">

    {{-- Toast container: wajib ada agar flash message & showToast() berfungsi --}}
    <div id="toast-container"
        class="fixed z-60 top-4 inset-x-4 sm:inset-x-auto sm:right-4 flex flex-col gap-2 sm:w-auto max-w-md sm:mx-0 mx-auto">
        @if (session('success'))
            <x-toast type="success" :duration="6000">{{ session('success') }}</x-toast>
        @endif

        @if (session('error'))
            <x-toast type="danger">{{ session('error') }}</x-toast>
        @endif

        @if ($errors->any())
            <x-toast type="danger" :duration="8000">
                <strong><i class="bi bi-exclamation-triangle-fill"></i> Terjadi Kesalahan!</strong>
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </x-toast>
        @endif
    </div>

    {{-- ===== MODAL KONFIRMASI LOGOUT ===== --}}
    <x-modal id="logoutModal" size="sm" centered>
        <x-slot:header>
            <i class="bi bi-box-arrow-right me-2 text-rose-500"></i>Konfirmasi Logout
        </x-slot:header>

        <p class="text-center text-sm">Yakin ingin keluar dari sistem?</p>

        <x-slot:footer>
            <x-button variant="light" data-modal-close>Batal</x-button>
            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <x-button type="submit" variant="danger">Logout</x-button>
            </form>
        </x-slot:footer>
    </x-modal>

    <div class="flex min-h-screen">

        {{-- Sidebar --}}
        {{-- Komponen x-sidebar sudah membungkus slot dalam <nav class="flex flex-1 flex-col gap-1">,
             jadi di sini cukup isi menunya langsung (jangan bungkus lagi dengan nav/h-full). --}}
        <x-sidebar id="mainSidebar" class="border-r border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-900">
            @php
                $aktif = 'bg-emerald-50 text-emerald-700 font-semibold dark:bg-emerald-500/15 dark:text-emerald-300';
                $hover =
                    'text-gray-600 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-gray-100';

                // [pola route aktif, route tujuan, nama menu, ikon]
                $menu = [
                    ['user.sekolah.*', 'user.sekolah.index', 'Data Sekolah', 'bi-building'],
                    ['user.siswa.*', 'user.siswa.index', 'Data Siswa', 'bi-people'],
                    ['user.pegawai.*', 'user.pegawai.index', 'Data Pegawai', 'bi-person-badge'],
                ];
            @endphp

            {{-- Profil (saat collapse: hanya avatar) --}}
            <div
                class="mb-4 flex items-center gap-3 border-b border-gray-100 pb-4 dark:border-gray-800 in-data-[sidebar-collapsed=true]:justify-center in-data-[sidebar-collapsed=true]:gap-0 in-data-[sidebar-collapsed=true]:border-0 in-data-[sidebar-collapsed=true]:pb-0">
                <div
                    class="flex shrink-0 items-center justify-center in-data-[sidebar-collapsed=true]:*:h-9 in-data-[sidebar-collapsed=true]:*:w-9">
                    <x-avatar :name="Auth::user()?->name ?? 'User'" size="md" status="online" />
                </div>
                <div class="min-w-0 flex-1" data-sidebar-label>
                    <p class="truncate text-sm font-semibold text-gray-800 dark:text-gray-100"
                        title="{{ Auth::user()?->name ?? 'User' }}">{{ Auth::user()?->name ?? 'User' }}</p>
                    <p class="truncate text-xs text-emerald-600 dark:text-emerald-400">Operator Sekolah</p>
                </div>
            </div>

            <p class="mb-1 px-2 text-[11px] font-medium uppercase tracking-wider text-gray-400 dark:text-gray-500"
                data-sidebar-label>
                Menu Utama
            </p>

            @foreach ($menu as [$pola, $rute, $nama, $ikon])
                @php $on = request()->routeIs($pola); @endphp
                <a href="{{ route($rute) }}" title="{{ $nama }}"
                    class="sidebar-link group relative rounded-lg in-data-[sidebar-collapsed=true]:justify-center in-data-[sidebar-collapsed=true]:px-1 {{ $on ? $aktif : $hover }}"
                    @if ($on) aria-current="page" @endif>
                    @if ($on)
                        <span class="absolute inset-y-2 left-0 w-0.5 rounded-r-full bg-emerald-600 dark:bg-emerald-400"
                            aria-hidden="true"></span>
                    @endif
                    <span
                        class="inline-flex h-8 w-8 shrink-0 items-center justify-center text-lg {{ $on ? '' : 'text-emerald-600 dark:text-emerald-400' }}">
                        <i class="bi {{ $ikon }}"></i>
                    </span>
                    <span class="truncate" data-sidebar-label>{{ $nama }}</span>
                </a>
            @endforeach

            {{-- Logout: mt-auto mendorongnya ke dasar sidebar (slot berada di dalam nav flex-1) --}}
            <div class="mt-auto border-t border-gray-100 pt-3 dark:border-gray-800">
                <button type="button" data-modal-open="logoutModal" title="Logout"
                    class="sidebar-link group w-full rounded-lg text-left text-gray-500 hover:bg-rose-50 hover:text-rose-600 dark:text-gray-400 dark:hover:bg-rose-500/10 dark:hover:text-rose-400 in-data-[sidebar-collapsed=true]:justify-center in-data-[sidebar-collapsed=true]:px-1">
                    <span class="inline-flex h-8 w-8 shrink-0 items-center justify-center text-lg">
                        <i class="bi bi-box-arrow-right"></i>
                    </span>
                    <span class="truncate" data-sidebar-label>Logout</span>
                </button>
            </div>
        </x-sidebar>

        {{-- Kolom kanan: navbar (sticky) + konten + footer --}}
        <div class="flex flex-col flex-1 min-w-0">

            <x-navbar
                class="sticky top-0 z-30 border-b border-gray-200 bg-white/90 backdrop-blur dark:border-gray-800 dark:bg-gray-900/90">
                <x-slot:brand>
                    <div class="flex items-center gap-2 min-w-0">
                        <button data-sidebar-open="mainSidebar"
                            class="inline-flex items-center justify-center rounded-md p-1.5 text-emerald-600 hover:bg-emerald-50 dark:text-emerald-400 dark:hover:bg-gray-800 sm:hidden shrink-0"
                            aria-label="Buka menu">
                            <i class="bi bi-list text-2xl leading-none"></i>
                        </button>
                        <span class="flex items-center gap-2 font-semibold text-gray-800 dark:text-gray-100 truncate">
                            <span
                                class="inline-flex h-7 w-7 shrink-0 items-center justify-center rounded-lg bg-emerald-600 text-sm text-white">
                                <i class="bi bi-building"></i>
                            </span>
                            <span class="truncate text-sm sm:text-base">SIMANDIK-SMP</span>
                        </span>
                    </div>
                </x-slot:brand>

                <x-slot:actions>
                    <div class="flex items-center gap-2">
                        {{-- Tombol ganti tema --}}
                        <button type="button" id="themeToggle" title="Ganti tema" aria-label="Ganti tema terang/gelap"
                            class="inline-flex h-9 w-9 items-center justify-center rounded-lg text-gray-500 transition hover:bg-emerald-50 hover:text-emerald-600 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-emerald-300">
                            <i class="bi bi-moon-stars dark:hidden"></i>
                            <i class="bi bi-sun hidden dark:inline"></i>
                        </button>

                        {{-- Dropdown profil: logout membuka modal konfirmasi di atas --}}
                        <x-dropdown align="right">
                            <x-slot:trigger>
                                <button type="button"
                                    class="flex items-center gap-2 rounded-lg p-1 sm:pr-2 transition hover:bg-emerald-50 dark:hover:bg-gray-800">
                                    <x-avatar :name="Auth::user()?->name ?? 'User'" size="xs" />
                                    <span
                                        class="hidden sm:block max-w-32 truncate text-sm text-gray-700 dark:text-gray-200">{{ Auth::user()?->name ?? 'User' }}</span>
                                    <i class="bi bi-chevron-down hidden text-xs text-gray-400 sm:inline"></i>
                                </button>
                            </x-slot:trigger>

                            <div class="border-b border-gray-100 px-3 py-2 dark:border-gray-700">
                                <p class="truncate text-sm font-semibold text-gray-800 dark:text-gray-100">
                                    {{ Auth::user()?->name ?? 'User' }}</p>
                                <p class="text-xs text-emerald-600 dark:text-emerald-400">Operator Sekolah</p>
                            </div>
                            <x-dropdown.item danger data-modal-open="logoutModal">
                                <i class="bi bi-box-arrow-right me-2"></i> Logout
                            </x-dropdown.item>
                        </x-dropdown>
                    </div>
                </x-slot:actions>
            </x-navbar>

            <main class="flex-1 w-full min-w-0">
                <div class="p-3 sm:p-4 lg:p-6 max-w-[1600px] mx-auto flex flex-col gap-4 min-w-0">
                    @hasSection('title')
                        <x-breadcrumb :items="[
                            ['label' => 'Beranda', 'url' => route('user.sekolah.index')],
                            ['label' => trim($__env->yieldContent('title'))],
                        ]" />
                    @endif

                    @yield('content')
                </div>
            </main>

            <footer
                class="border-t border-gray-200 px-3 py-4 text-center text-xs text-gray-400 dark:border-gray-800 dark:text-gray-600 sm:px-4 lg:px-6">
                &copy; {{ date('Y') }} <span class="font-medium text-emerald-600">SIMANDIK-SMP</span>
            </footer>
        </div>
    </div>

    {{-- Script ganti tema --}}
    <script>
        document.getElementById('themeToggle')?.addEventListener('click', function() {
            var gelap = document.documentElement.classList.toggle('dark');
            try {
                localStorage.setItem('theme', gelap ? 'dark' : 'light');
            } catch (e) {}
        });
    </script>

    {{-- Script per-halaman (@push('scripts') di masing-masing view) --}}
    @stack('scripts')

</body>

</html>
