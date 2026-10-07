{{--
    Komponen: Card
    Fungsi: Kontainer konten dengan header, body, dan footer opsional.

    Props (slot bernama):
    - header : slot untuk bagian atas card (opsional)
    - footer : slot untuk bagian bawah card (opsional)
    - $slot  : isi utama (body)

    Contoh:
    <x-card>
        <x-slot:header>Judul Card</x-slot:header>
        Isi konten card di sini.
        <x-slot:footer>
            <x-button size="sm">Aksi</x-button>
        </x-slot:footer>
    </x-card>
--}}
@props([])

<div {{ $attributes->class([
    'w-full rounded-xl border border-gray-200 bg-white shadow-sm overflow-hidden',
    'dark:bg-gray-800 dark:border-gray-700',
]) }}>
    @isset($header)
        <div class="border-b border-gray-200 dark:border-gray-700 px-4 py-3 sm:px-5 font-semibold text-gray-800 dark:text-gray-100">
            {{ $header }}
        </div>
    @endisset

    <div class="px-4 py-4 sm:px-5 text-gray-700 dark:text-gray-300">
        {{ $slot }}
    </div>

    @isset($footer)
        <div class="border-t border-gray-200 dark:border-gray-700 px-4 py-3 sm:px-5 bg-gray-50 dark:bg-gray-900/40">
            {{ $footer }}
        </div>
    @endisset
</div>
