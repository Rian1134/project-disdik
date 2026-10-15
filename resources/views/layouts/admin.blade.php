<!doctype html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        @hasSection('title')
            @yield('title') -
        @endif SIMANDIK-SMP
    </title>
    <link rel="icon" type="image/webp" href="{{ asset('assets/img/icon-web.webp') }}">
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

    {{-- CSS per-halaman (@push('styles') di masing-masing view) --}}
    @stack('styles')
</head>

<body class="bg-gray-50 text-gray-800 antialiased dark:bg-gray-900 dark:text-gray-100">

    @php
        // URL logo user yang sedang login (null jika belum upload)
        $logo = Auth::user()?->logo ? asset('uploads/logo/' . Auth::user()->logo) : null;
    @endphp

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

    <div class="flex min-h-dvh">

        {{-- Sidebar --}}
        {{-- Komponen x-sidebar sudah membungkus slot dalam <nav class="flex flex-1 flex-col gap-1">,
             jadi di sini cukup isi menunya langsung (jangan bungkus lagi dengan nav/h-full). --}}
        <x-sidebar id="mainSidebar" class="border-r border-blue-900 bg-blue-950">
            @php
                $aktif = 'bg-white/15 text-white font-semibold';
                $hover = 'text-blue-100 hover:bg-white/10 hover:text-white';

                // [pola route aktif, route tujuan, nama menu, ikon]
                $menu = [
                    ['admin.sekolah.*', 'admin.sekolah.index', 'Data Sekolah', 'bi-building'],
                    ['admin.siswa.*', 'admin.siswa.index', 'Data Siswa', 'bi-people'],
                    ['admin.pegawai.*', 'admin.pegawai.index', 'Data Pegawai', 'bi-person-badge'],
                    ['admin.users.*', 'admin.users.index', 'Users', 'bi-person-gear'],
                    ['admin.persetujuan-*', 'admin.persetujuan-siswa.index', 'Persetujuan', 'bi-clipboard-check'],
                ];
            @endphp

            {{-- Profil (saat collapse: hanya avatar) --}}
            <div
                class="mb-4 flex items-center gap-3 border-b border-white/10 pb-4 in-data-[sidebar-collapsed=true]:justify-center in-data-[sidebar-collapsed=true]:gap-0 in-data-[sidebar-collapsed=true]:border-0 in-data-[sidebar-collapsed=true]:pb-0">
                <div
                    class="flex shrink-0 items-center justify-center in-data-[sidebar-collapsed=true]:*:h-9 in-data-[sidebar-collapsed=true]:*:w-9">
                    @if ($logo)
                        <img src="{{ $logo }}" alt="Logo" class="h-10 w-10 rounded-full object-cover">
                    @else
                        <x-avatar :name="Auth::user()?->name ?? 'Admin'" size="md" status="online" />
                    @endif
                </div>
                <div class="min-w-0 flex-1" data-sidebar-label>
                    <p class="truncate text-sm font-semibold text-white" title="{{ Auth::user()?->name ?? 'Admin' }}">
                        {{ Auth::user()?->name ?? 'Admin' }}</p>
                    <p class="truncate text-xs text-sky-300">Admin</p>
                </div>
            </div>

            <p class="mb-1 px-2 text-[11px] font-medium uppercase tracking-wider text-blue-300/70" data-sidebar-label>
                Menu
            </p>

            @foreach ($menu as [$pola, $rute, $nama, $ikon])
                @php $on = request()->routeIs($pola); @endphp
                <a href="{{ route($rute) }}" title="{{ $nama }}"
                    class="sidebar-link group relative rounded-lg in-data-[sidebar-collapsed=true]:justify-center in-data-[sidebar-collapsed=true]:px-1 {{ $on ? $aktif : $hover }}"
                    @if ($on) aria-current="page" @endif>
                    @if ($on)
                        <span class="absolute inset-y-2 left-0 w-0.5 rounded-r-full bg-sky-300"
                            aria-hidden="true"></span>
                    @endif
                    <span
                        class="inline-flex h-8 w-8 shrink-0 items-center justify-center text-lg {{ $on ? '' : 'text-sky-300' }}">
                        <i class="bi {{ $ikon }}"></i>
                    </span>
                    <span class="truncate" data-sidebar-label>{{ $nama }}</span>
                </a>
            @endforeach

            {{-- Logout: mt-auto mendorongnya ke dasar sidebar (slot berada di dalam nav flex-1) --}}
            <div class="mt-auto border-t border-white/10 pt-3">
                <button type="button" data-modal-open="logoutModal" title="Logout"
                    class="sidebar-link group w-full rounded-lg text-left text-blue-100 hover:bg-rose-500/20 hover:text-rose-300 in-data-[sidebar-collapsed=true]:justify-center in-data-[sidebar-collapsed=true]:px-1">
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
                            class="inline-flex items-center justify-center rounded-md p-1.5 text-blue-600 hover:bg-blue-50 dark:text-blue-400 dark:hover:bg-gray-800 sm:hidden shrink-0"
                            aria-label="Buka menu">
                            <i class="bi bi-list text-2xl leading-none"></i>
                        </button>
                        <span class="flex items-center gap-2 font-semibold text-gray-800 dark:text-gray-100 truncate">
                            <span
                                class="inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-white p-0.5 ring-1 ring-gray-200 dark:ring-gray-700">
                                <img src="{{ asset('assets/img/icon-web.webp') }}" alt="Logo SIMANDIK-SMP"
                                    class="h-full w-full object-contain">
                            </span>
                            <span class="truncate text-sm sm:text-base">SIMANDIK-SMP</span>
                        </span>
                    </div>
                </x-slot:brand>

                <x-slot:actions>
                    <div class="flex items-center gap-2">
                        {{-- Tombol ganti tema --}}
                        <button type="button" id="themeToggle" title="Ganti tema" aria-label="Ganti tema terang/gelap"
                            class="inline-flex h-9 w-9 items-center justify-center rounded-lg text-gray-500 transition hover:bg-blue-50 hover:text-blue-600 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-blue-300">
                            <i class="bi bi-moon-stars dark:hidden"></i>
                            <i class="bi bi-sun hidden dark:inline"></i>
                        </button>

                        {{-- Dropdown profil: logout membuka modal konfirmasi di atas --}}
                        <x-dropdown align="right">
                            <x-slot:trigger>
                                <button type="button"
                                    class="flex items-center gap-2 rounded-lg p-1 sm:pr-2 transition hover:bg-blue-50 dark:hover:bg-gray-800">
                                    @if ($logo)
                                        <img src="{{ $logo }}" alt="Logo"
                                            class="h-7 w-7 rounded-full object-cover">
                                    @else
                                        <x-avatar :name="Auth::user()?->name ?? 'Admin'" size="xs" />
                                    @endif
                                    <span
                                        class="hidden sm:block max-w-32 truncate text-sm text-gray-700 dark:text-gray-200">{{ Auth::user()?->name ?? 'Admin' }}</span>
                                    <i class="bi bi-chevron-down hidden text-xs text-gray-400 sm:inline"></i>
                                </button>
                            </x-slot:trigger>

                            <div class="border-b border-gray-100 px-3 py-2 dark:border-gray-700">
                                <p class="truncate text-sm font-semibold text-gray-800 dark:text-gray-100">
                                    {{ Auth::user()?->name ?? 'Admin' }}</p>
                                <p class="text-xs text-blue-600 dark:text-blue-400">Admin</p>
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
                            ['label' => 'Beranda', 'url' => route('admin.sekolah.index')],
                            ['label' => trim($__env->yieldContent('title'))],
                        ]" />
                    @endif

                    @yield('content')
                </div>
            </main>

            <footer
                class="border-t border-gray-200 px-3 py-4 text-center text-xs text-gray-400 dark:border-gray-800 dark:text-gray-600 sm:px-4 lg:px-6">
                &copy; {{ date('Y') }} <span class="font-medium text-blue-600">SIMANDIK-SMP</span>
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
