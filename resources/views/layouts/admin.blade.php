<!doctype html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIMANDIK-SMP - @yield('title')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 dark:bg-gray-900">

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
        <x-slot:header>Konfirmasi Logout</x-slot:header>

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

        {{-- Sidebar putih polos, tanpa warna aksen --}}
        <x-sidebar id="mainSidebar" class="bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700">
            <div class="flex items-center gap-3 border-b border-gray-200 dark:border-gray-700 pb-4 mb-3">
                <x-avatar :name="Auth::user()?->name ?? 'Admin'" size="md" />
                <div class="min-w-0 flex-1" data-sidebar-label>
                    <p class="truncate text-sm font-semibold text-gray-800 dark:text-gray-100">{{ Auth::user()?->name ?? 'Admin' }}</p>
                    <p class="truncate text-xs text-gray-500 dark:text-gray-400">Admin</p>
                </div>
            </div>

            <p class="px-2 mb-1 text-[11px] font-semibold uppercase tracking-wider text-gray-400" data-sidebar-label>
                Menu Utama
            </p>

            <a href="{{ route('admin.sekolah.index') }}"
                class="sidebar-link {{ request()->routeIs('admin.sekolah.*') ? 'bg-gray-100 dark:bg-gray-700 font-semibold' : '' }}"
                @if (request()->routeIs('admin.sekolah.*')) aria-current="page" @endif>
                <i class="bi bi-building-fill text-base shrink-0"></i>
                <span data-sidebar-label>Data Sekolah</span>
            </a>

            <a href="{{ route('admin.siswa.index') }}"
                class="sidebar-link {{ request()->routeIs('admin.siswa.*') ? 'bg-gray-100 dark:bg-gray-700 font-semibold' : '' }}"
                @if (request()->routeIs('admin.siswa.*')) aria-current="page" @endif>
                <i class="bi bi-people-fill text-base shrink-0"></i>
                <span data-sidebar-label>Data Siswa</span>
            </a>

            <a href="{{ route('admin.pegawai.index') }}"
                class="sidebar-link {{ request()->routeIs('admin.pegawai.*') ? 'bg-gray-100 dark:bg-gray-700 font-semibold' : '' }}"
                @if (request()->routeIs('admin.pegawai.*')) aria-current="page" @endif>
                <i class="bi bi-person-badge-fill text-base shrink-0"></i>
                <span data-sidebar-label>Data Pegawai</span>
            </a>

            <a href="{{ route('admin.users.index') }}"
                class="sidebar-link {{ request()->routeIs('admin.user.*') ? 'bg-gray-100 dark:bg-gray-700 font-semibold' : '' }}"
                @if (request()->routeIs('admin.user.*')) aria-current="page" @endif>
                <i class="bi bi-person-fill-gear text-base shrink-0"></i>
                <span data-sidebar-label>Users</span>
            </a>

            <button type="button" data-modal-open="logoutModal"
                class="sidebar-link mt-auto w-full text-left border-t border-gray-200 dark:border-gray-700 pt-3">
                <i class="bi bi-box-arrow-right text-base shrink-0"></i>
                <span data-sidebar-label>Logout</span>
            </button>
        </x-sidebar>

        {{-- Kolom kanan: navbar (sticky) + konten + footer --}}
        <div class="flex flex-col flex-1 min-w-0">

            <x-navbar class="sticky top-0 z-30 shadow-sm">
                <x-slot:brand>
                    <div class="flex items-center gap-2 min-w-0">
                        <button data-sidebar-open="mainSidebar"
                            class="inline-flex items-center justify-center rounded-md p-1.5 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 sm:hidden shrink-0"
                            aria-label="Buka menu">
                            <i class="bi bi-list text-2xl leading-none"></i>
                        </button>
                        <span class="flex items-center gap-1.5 font-semibold text-gray-800 dark:text-gray-100 truncate">
                            <span
                                class="inline-flex items-center justify-center w-7 h-7 rounded-lg border border-gray-300 dark:border-gray-600 text-sm shrink-0">
                                <i class="bi bi-building"></i>
                            </span>
                            <span class="truncate text-sm sm:text-base">SIMANDIK-SMP</span>
                        </span>
                        @hasSection('title')
                            <span
                                class="hidden md:flex items-center gap-2 text-gray-400 dark:text-gray-500 text-sm min-w-0">
                                <span>/</span>
                                <span class="truncate text-gray-600 dark:text-gray-300">@yield('title')</span>
                            </span>
                        @endif
                    </div>
                </x-slot:brand>

                <x-slot:actions>
                    <div class="flex items-center gap-2">
                        <x-avatar :name="Auth::user()?->name ?? 'Admin'" size="xs" />
                        <span class="hidden sm:block max-w-32 truncate text-sm text-gray-700 dark:text-gray-200">{{ Auth::user()?->name ?? 'Admin' }}</span>
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
                &copy; {{ date('Y') }} SIMANDIK-SMP
            </footer>
        </div>
    </div>

    {{-- Script per-halaman (@push('scripts') di masing-masing view) --}}
    @stack('scripts')

</body>

</html>