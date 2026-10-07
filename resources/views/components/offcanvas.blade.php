{{--
    Komponen: Offcanvas
    Fungsi: Panel yang muncul dari sisi layar (kiri/kanan), mirip drawer.

    Props:
    - id        : string wajib, id unik offcanvas
    - placement : start | end (kiri/kanan, default: end)

    Slot bernama:
    - header (opsional)
    - $slot  : isi konten

    Cara membuka (lihat resources/js/offcanvas.js):
    <button data-offcanvas-open="filterPanel">Buka Filter</button>

    Contoh:
    <x-offcanvas id="filterPanel" placement="end">
        <x-slot:header>Filter Produk</x-slot:header>
        Isi form filter di sini.
    </x-offcanvas>
--}}
@props([
    'id',
    'placement' => 'end',
])

<div id="{{ $id }}" data-offcanvas class="fixed inset-0 z-50 hidden" aria-hidden="true">
    <div data-offcanvas-backdrop class="fixed inset-0 bg-gray-900/60"></div>

    <div
        data-offcanvas-panel
        {{ $attributes->class([
            'fixed top-0 h-full w-[85%] sm:w-96 bg-white dark:bg-gray-800 shadow-xl flex flex-col transition-transform duration-300',
            'left-0 -translate-x-full' => $placement === 'start',
            'right-0 translate-x-full' => $placement === 'end',
        ]) }}
    >
        @isset($header)
            <div class="flex items-center justify-between border-b border-gray-200 dark:border-gray-700 px-4 py-3">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">{{ $header }}</h3>
                <button type="button" data-offcanvas-close class="rounded-md p-1 text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700" aria-label="Tutup">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        @endisset

        <div class="flex-1 overflow-y-auto px-4 py-4 text-gray-700 dark:text-gray-300">
            {{ $slot }}
        </div>
    </div>
</div>
