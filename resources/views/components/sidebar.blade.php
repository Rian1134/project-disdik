{{--
    Komponen: Sidebar
    Fungsi: Navigasi samping. Selalu tampil di desktop, menjadi drawer di mobile.
            Mendukung mode collapse (hanya ikon) di desktop lewat tombol toggle.

    Props:
    - id         : string wajib, id unik sidebar (untuk toggle drawer mobile & collapse desktop)
    - collapsed  : boolean, mode collapse (hanya ikon) saat halaman dimuat, default: false
    - toggle     : boolean, tampilkan tombol collapse/expand di desktop, default: true

    Slot:
    - $slot : isi menu, gunakan <a class="sidebar-link"> berisi ikon + <span data-sidebar-label>Teks</span>
              agar teksnya otomatis tersembunyi saat sidebar di-collapse.

    Cara membuka di mobile (lihat resources/js/sidebar.js):
    <button data-sidebar-open="mainSidebar">Buka Menu</button>

    Contoh:
    <x-sidebar id="mainSidebar">
        <a href="/dashboard" class="sidebar-link active">
            <svg class="h-5 w-5 shrink-0">...</svg>
            <span data-sidebar-label>Dashboard</span>
        </a>
        <a href="/users" class="sidebar-link">
            <svg class="h-5 w-5 shrink-0">...</svg>
            <span data-sidebar-label>Pengguna</span>
        </a>
    </x-sidebar>
--}}
@props([
    'id',
    'collapsed' => false,
    'toggle' => true,
])

{{-- Backdrop mobile --}}
<div data-sidebar-backdrop="{{ $id }}" class="fixed inset-0 z-40 hidden bg-gray-900/60 sm:hidden"></div>

<aside
    id="{{ $id }}"
    data-sidebar
    data-sidebar-collapsed="{{ $collapsed ? 'true' : 'false' }}"
    {{ $attributes->class([
        'fixed sm:sticky top-0 z-50 sm:z-0 h-screen sm:h-[calc(100vh)]',
        'w-64 -translate-x-full sm:translate-x-0',
        'transition-all duration-200 ease-in-out',
        'sm:w-16' => $collapsed,
    ]) }}
>
    <div class="flex h-full flex-col overflow-y-auto px-3 py-4">
        <div class="mb-4 flex items-center justify-between">
            @if($toggle)
                <button
                    data-sidebar-collapse-toggle="{{ $id }}"
                    class="hidden sm:inline-flex rounded-md p-1.5 text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700"
                    aria-label="Ciutkan/lebarkan menu"
                >
                    <svg class="h-5 w-5 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" data-sidebar-collapse-icon>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                    </svg>
                </button>
            @endif

            <button data-sidebar-close="{{ $id }}" class="ml-auto rounded-md p-1 text-gray-400 hover:bg-gray-100 sm:hidden" aria-label="Tutup menu">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <nav class="flex flex-1 flex-col gap-1">
            {{ $slot }}
        </nav>
    </div>
</aside>
