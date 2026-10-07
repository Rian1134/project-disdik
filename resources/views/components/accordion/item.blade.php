{{--
    Komponen: Accordion Item
    Fungsi: Satu panel pada komponen <x-accordion>.

    Props:
    - title : string, judul panel yang selalu tampil
    - open  : boolean, apakah panel terbuka saat halaman dimuat (default: false)

    Contoh:
    <x-accordion.item title="Judul Panel" open>
        Isi konten panel.
    </x-accordion.item>
--}}
@props([
    'title' => '',
    'open' => false,
])

<div class="accordion-item" data-accordion-item>
    <button
        type="button"
        data-accordion-trigger
        class="flex w-full items-center justify-between gap-3 px-4 py-3 text-left font-medium text-gray-800 hover:bg-gray-50 dark:text-gray-100 dark:hover:bg-gray-700/50 transition-colors"
        aria-expanded="{{ $open ? 'true' : 'false' }}"
    >
        <span>{{ $title }}</span>
        <svg data-accordion-icon class="h-5 w-5 flex-shrink-0 text-gray-400 transition-transform duration-200 {{ $open ? 'rotate-180' : '' }}" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
        </svg>
    </button>
    <div data-accordion-content class="overflow-hidden transition-all duration-200 {{ $open ? '' : 'hidden' }}">
        <div class="px-4 pb-4 pt-0 text-sm text-gray-600 dark:text-gray-300">
            {{ $slot }}
        </div>
    </div>
</div>
