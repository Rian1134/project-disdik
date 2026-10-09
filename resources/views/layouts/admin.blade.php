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

<body class="bg-slate-50 text-gray-800 dark:bg-gray-900 dark:text-gray-100">

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
        <x-sidebar id="mainSidebar" class="border-r bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700">
            @php
                $aktif = 'bg-indigo-50 text-indigo-700 font-semibold dark:bg-indigo-500/20 dark:text-indigo-200';
                $hover =
                    'text-gray-600 hover:bg-slate-100 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-gray-700 dark:hover:text-white';

                // Tambah menu baru cukup menambah satu baris di sini.
                $menu = [
                    [
                        'route' => 'admin.sekolah.index',
                        'pattern' => 'admin.sekolah.*',
                        'label' => 'Data Sekolah',
                        'icon' => 'bi-building-fill',
                        'tile' => 'bg-indigo-100 text-indigo-600 dark:bg-indigo-500/20 dark:text-indigo-300',
                    ],
                    [
                        'route' => 'admin.siswa.index',
                        'pattern' => 'admin.siswa.*',
                        'label' => 'Data Siswa',
                        'icon' => 'bi-people-fill',
                        'tile' => 'bg-emerald-100 text-emerald-600 dark:bg-emerald-500/20 dark:text-emerald-300',
                    ],
                    [
                        'route' => 'admin.pegawai.index',
                        'pattern' => 'admin.pegawai.*',
                        'label' => 'Data Pegawai',
                        'icon' => 'bi-person-badge-fill',
                        'tile' => 'bg-amber-100 text-amber-600 dark:bg-amber-500/20 dark:text-amber-300',
                    ],
                    [
                        'route' => 'admin.users.index',
                        'pattern' => 'admin.users.*',
                        'label' => 'Users',
                        'icon' => 'bi-person-fill-gear',
                        'tile' => 'bg-sky-100 text-sky-600 dark:bg-sky-500/20 dark:text-sky-300',
                    ],
                ];
            @endphp

            {{-- Profil (saat collapse: hanya avatar, tanpa padding berlebih) --}}
            <div
                class="mb-3 flex items-center gap-3 rounded-xl bg-gradient-to-br from-indigo-50 to-sky-50 p-3 ring-1 ring-indigo-100 dark:from-indigo-500/10 dark:to-sky-500/10 dark:ring-indigo-500/20 [[data-sidebar-collapsed=true]_&]:justify-center [[data-sidebar-collapsed=true]_&]:gap-0 [[data-sidebar-collapsed=true]_&]:bg-none [[data-sidebar-collapsed=true]_&]:p-0 [[data-sidebar-collapsed=true]_&]:ring-0">
                {{-- shrink-0 agar avatar tidak gepeng; saat collapse dipaksa 36px agar muat di lebar 40px --}}
                <div
                    class="flex shrink-0 items-center justify-center [[data-sidebar-collapsed=true]_&]:[&>*]:h-9 [[data-sidebar-collapsed=true]_&]:[&>*]:w-9">
                    <x-avatar :name="Auth::user()?->name ?? 'Admin'" size="md" />
                </div>
                <div class="min-w-0 flex-1" data-sidebar-label>
                    <p class="truncate text-sm font-semibold text-gray-800 dark:text-gray-100"
                        title="{{ Auth::user()?->name ?? 'Admin' }}">{{ Auth::user()?->name ?? 'Admin' }}</p>
                    <p class="truncate text-xs font-medium text-indigo-600 dark:text-indigo-300">Admin</p>
                </div>
            </div>

            <p class="mb-1 px-2 text-[11px] font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-500"
                data-sidebar-label>
                Menu Utama
            </p>

            @foreach ($menu as $item)
                @php $on = request()->routeIs($item['pattern']); @endphp
                <a href="{{ route($item['route']) }}" title="{{ $item['label'] }}"
                    class="sidebar-link group relative rounded-lg [[data-sidebar-collapsed=true]_&]:justify-center [[data-sidebar-collapsed=true]_&]:px-1 {{ $on ? $aktif : $hover }}"
                    @if ($on) aria-current="page" @endif>
                    @if ($on)
                        <span class="absolute inset-y-1.5 left-0 w-1 rounded-r-full bg-indigo-600 dark:bg-indigo-400"
                            aria-hidden="true"></span>
                    @endif
                    <span
                        class="inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-lg text-base transition-transform group-hover:scale-105 {{ $item['tile'] }}">
                        <i class="bi {{ $item['icon'] }}"></i>
                    </span>
                    <span class="truncate" data-sidebar-label>{{ $item['label'] }}</span>
                </a>
            @endforeach

            {{-- Logout: mt-auto mendorongnya ke dasar sidebar (slot berada di dalam nav flex-1) --}}
            <div class="mt-auto border-t border-gray-200 pt-3 dark:border-gray-700">
                <button type="button" data-modal-open="logoutModal" title="Logout"
                    class="sidebar-link group w-full rounded-lg text-left text-rose-600 hover:bg-rose-50 dark:text-rose-400 dark:hover:bg-rose-500/10 [[data-sidebar-collapsed=true]_&]:justify-center [[data-sidebar-collapsed=true]_&]:px-1">
                    <span
                        class="inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-rose-100 text-base text-rose-600 dark:bg-rose-500/20 dark:text-rose-300">
                        <i class="bi bi-box-arrow-right"></i>
                    </span>
                    <span class="truncate" data-sidebar-label>Logout</span>
                </button>
            </div>
        </x-sidebar>

        {{-- Kolom kanan: navbar (sticky) + konten + footer --}}
        <div class="flex flex-col flex-1 min-w-0">

            <x-navbar class="sticky top-0 z-30 shadow-sm border-b-2 border-indigo-500">
                <x-slot:brand>
                    <div class="flex items-center gap-2 min-w-0">
                        <button data-sidebar-open="mainSidebar"
                            class="inline-flex items-center justify-center rounded-md p-1.5 text-indigo-600 dark:text-indigo-300 hover:bg-indigo-50 dark:hover:bg-gray-700 sm:hidden shrink-0"
                            aria-label="Buka menu">
                            <i class="bi bi-list text-2xl leading-none"></i>
                        </button>
                        <span class="flex items-center gap-1.5 font-semibold text-gray-800 dark:text-gray-100 truncate">
                            <span
                                class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-indigo-600 text-white text-sm shrink-0">
                                <i class="bi bi-building"></i>
                            </span>
                            <span class="truncate text-sm sm:text-base">SIMANDIK-SMP</span>
                        </span>
                        @hasSection('title')
                            <span
                                class="hidden md:flex items-center gap-2 text-gray-400 dark:text-gray-500 text-sm min-w-0">
                                <span>/</span>
                                <span
                                    class="truncate font-medium text-indigo-600 dark:text-indigo-300">@yield('title')</span>
                            </span>
                        @endif
                    </div>
                </x-slot:brand>

                <x-slot:actions>
                    <div class="flex items-center gap-2">
                        {{-- Tombol ganti tema --}}
                        <button type="button" id="themeToggle" title="Ganti tema" aria-label="Ganti tema terang/gelap"
                            class="inline-flex h-9 w-9 items-center justify-center rounded-lg text-gray-600 transition hover:bg-slate-100 dark:text-amber-300 dark:hover:bg-gray-700">
                            <i class="bi bi-moon-stars-fill dark:hidden"></i>
                            <i class="bi bi-sun-fill hidden dark:inline"></i>
                        </button>
                        <x-avatar :name="Auth::user()?->name ?? 'Admin'" size="xs" />
                        <span
                            class="hidden sm:block max-w-32 truncate text-sm text-gray-700 dark:text-gray-200">{{ Auth::user()?->name ?? 'Admin' }}</span>
                    </div>
                </x-slot:actions>
            </x-navbar>

            <main class="flex-1 w-full min-w-0">
                <div class="p-3 sm:p-4 lg:p-6 max-w-[1600px] mx-auto flex flex-col gap-4 min-w-0">
                    @yield('content')
                </div>
            </main>

            <footer
                class="px-3 sm:px-4 lg:px-6 py-4 text-center text-xs text-gray-400 dark:text-gray-600 border-t border-gray-200 dark:border-gray-800">
                &copy; {{ date('Y') }} <span class="font-medium text-indigo-500">SIMANDIK-SMP</span>
            </footer>
        </div>
    </div>

    {{-- Script per-halaman (@push('scripts') di masing-masing view) --}}
    <script>
        document.getElementById('themeToggle')?.addEventListener('click', function() {
            var gelap = document.documentElement.classList.toggle('dark');
            try {
                localStorage.setItem('theme', gelap ? 'dark' : 'light');
            } catch (e) {}
        });
    </script>

    @stack('scripts')

</body>

</html>
