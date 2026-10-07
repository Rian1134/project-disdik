{{--
    Komponen: Tabs Pane
    Fungsi: Isi konten satu tab.

    Props:
    - id     : string wajib, harus sama dengan target di <x-tabs.link>
    - active : boolean, tampil saat halaman dimuat (default: false)

    Contoh:
    <x-tabs.pane id="tab-akun" active>Isi konten tab akun.</x-tabs.pane>
--}}
@props([
    'id',
    'active' => false,
])

<div
    id="{{ $id }}"
    data-tabs-pane
    role="tabpanel"
    {{ $attributes->class(['text-sm text-gray-600 dark:text-gray-300', $active ? '' : 'hidden']) }}
>
    {{ $slot }}
</div>
