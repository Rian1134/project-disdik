{{--
    Komponen: Tabs (wadah)
    Fungsi: Navigasi antar konten dalam satu area, horizontal atau vertikal.

    Props:
    - id          : string wajib, id unik grup tabs
    - orientation : horizontal | vertical (default: horizontal)

    Slot bernama:
    - nav   : daftar <x-tabs.link> (tombol tab)
    - $slot : daftar <x-tabs.pane> (isi konten tiap tab)

    Contoh:
    <x-tabs id="profileTabs">
        <x-slot:nav>
            <x-tabs.link target="tab-akun" active>Akun</x-tabs.link>
            <x-tabs.link target="tab-keamanan">Keamanan</x-tabs.link>
        </x-slot:nav>

        <x-tabs.pane id="tab-akun" active>Konten akun...</x-tabs.pane>
        <x-tabs.pane id="tab-keamanan">Konten keamanan...</x-tabs.pane>
    </x-tabs>
--}}
@props([
    'id',
    'orientation' => 'horizontal',
])

<div id="{{ $id }}" data-tabs {{ $attributes->class([
    'flex flex-col gap-4',
    'sm:flex-row sm:gap-6' => $orientation === 'vertical',
]) }}>
    <div
        data-tabs-nav
        role="tablist"
        class="flex gap-1 border-b border-gray-200 dark:border-gray-700 overflow-x-auto
        {{ $orientation === 'vertical' ? 'sm:flex-col sm:border-b-0 sm:border-r sm:pr-2 sm:min-w-[10rem]' : '' }}"
    >
        {{ $nav }}
    </div>

    <div data-tabs-content class="flex-1 min-w-0">
        {{ $slot }}
    </div>
</div>
