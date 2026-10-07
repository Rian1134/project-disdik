{{--
    Komponen: Dropdown
    Fungsi: Menu melayang yang muncul saat tombol pemicu diklik.

    Props:
    - align : left | right (posisi menu terhadap tombol, default: left)

    Slot bernama:
    - trigger : elemen pemicu (biasanya <x-button>)
    - $slot   : isi menu (gunakan <x-dropdown.item> atau <a>/<button> manual)

    Contoh:
    <x-dropdown align="right">
        <x-slot:trigger>
            <x-button variant="light">Opsi</x-button>
        </x-slot:trigger>

        <a href="#" class="dropdown-item">Edit</a>
        <a href="#" class="dropdown-item">Duplikat</a>
        <div class="border-t border-gray-200 dark:border-gray-700 my-1"></div>
        <a href="#" class="dropdown-item text-red-600">Hapus</a>
    </x-dropdown>
--}}
@props([
    'align' => 'left',
])

<div class="relative inline-block text-left" data-dropdown>
    <div data-dropdown-trigger class="inline-flex">
        {{ $trigger }}
    </div>

    <div
        data-dropdown-menu
        {{ $attributes->class([
            'absolute z-30 mt-2 hidden min-w-[12rem] w-max max-w-xs rounded-lg border border-gray-200 bg-white py-1 shadow-lg',
            'dark:bg-gray-800 dark:border-gray-700',
            'left-0' => $align === 'left',
            'right-0' => $align === 'right',
        ]) }}
    >
        {{ $slot }}
    </div>
</div>
