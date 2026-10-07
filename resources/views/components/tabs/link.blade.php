{{--
    Komponen: Tabs Link
    Fungsi: Tombol pemicu satu tab.

    Props:
    - target : string wajib, harus sama dengan id <x-tabs.pane> yang dituju
    - active : boolean, aktif saat halaman dimuat (default: false)

    Contoh:
    <x-tabs.link target="tab-akun" active>Akun</x-tabs.link>
--}}
@props([
    'target',
    'active' => false,
])

<button
    type="button"
    data-tabs-link
    data-target="{{ $target }}"
    role="tab"
    aria-selected="{{ $active ? 'true' : 'false' }}"
    {{ $attributes->class([
        'whitespace-nowrap px-4 py-2.5 text-sm font-medium border-b-2 -mb-px transition-colors',
        'sm:border-b-0 sm:border-r-2 sm:-mr-px sm:text-left' => false,
        'border-blue-600 text-blue-600 dark:text-blue-400' => $active,
        'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-200' => !$active,
    ]) }}
>
    {{ $slot }}
</button>
