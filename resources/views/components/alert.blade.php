{{--
    Komponen: Alert
    Fungsi: Menampilkan pesan notifikasi (info, sukses, gagal, dsb).

    Props:
    - type        : primary | success | warning | danger | info (default: info)
    - dismissible : boolean, menampilkan tombol tutup (butuh resources/js/components.js)
    - icon        : boolean, menampilkan ikon bawaan (default: true)
    - autoDismiss : integer|null, kalau diisi (dalam milidetik) alert akan tertutup
                    sendiri otomatis setelah durasi tsb (butuh resources/js/alert.js).
                    Otomatis membuat alert jadi dismissible walau tidak ditulis eksplisit.

    Contoh:
    <x-alert type="success">Data berhasil disimpan.</x-alert>
    <x-alert type="danger" dismissible>Terjadi kesalahan pada server.</x-alert>
    <x-alert type="success" :auto-dismiss="5000">Data berhasil disimpan.</x-alert>
--}}
@props([
    'type' => 'info',
    'dismissible' => false,
    'icon' => true,
    'autoDismiss' => null,
])

@php
    // Alert yang auto-dismiss otomatis butuh tombol close juga (dipakai
    // sebagai "pemicu" animasi tutup yang sama lewat JS)
    $dismissible = $dismissible || $autoDismiss;
@endphp

@php
    $types = [
        'primary' => ['bg' => 'bg-blue-50 dark:bg-blue-950/40', 'text' => 'text-blue-800 dark:text-blue-200', 'border' => 'border-blue-200 dark:border-blue-800', 'icon' => 'text-blue-500'],
        'success' => ['bg' => 'bg-emerald-50 dark:bg-emerald-950/40', 'text' => 'text-emerald-800 dark:text-emerald-200', 'border' => 'border-emerald-200 dark:border-emerald-800', 'icon' => 'text-emerald-500'],
        'warning' => ['bg' => 'bg-yellow-50 dark:bg-yellow-950/40', 'text' => 'text-yellow-800 dark:text-yellow-200', 'border' => 'border-yellow-200 dark:border-yellow-800', 'icon' => 'text-yellow-500'],
        'danger'  => ['bg' => 'bg-red-50 dark:bg-red-950/40', 'text' => 'text-red-800 dark:text-red-200', 'border' => 'border-red-200 dark:border-red-800', 'icon' => 'text-red-500'],
        'info'    => ['bg' => 'bg-indigo-50 dark:bg-indigo-950/40', 'text' => 'text-indigo-800 dark:text-indigo-200', 'border' => 'border-indigo-200 dark:border-indigo-800', 'icon' => 'text-indigo-500'],
    ];
    $style = $types[$type] ?? $types['info'];

    $icons = [
        'success' => 'M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
        'danger'  => 'M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z',
        'warning' => 'M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z',
        'info'    => 'M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z',
        'primary' => 'M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z',
    ];
    $iconPath = $icons[$type] ?? $icons['info'];
@endphp

<div
    {{ $attributes->class([
        'flex items-start gap-3 rounded-lg border p-4 text-sm',
        $style['bg'], $style['text'], $style['border'],
    ]) }}
    @if($dismissible) data-alert x-data-alert @endif
    @if($autoDismiss) data-alert-auto-dismiss="{{ $autoDismiss }}" @endif
    role="alert"
>
    @if($icon)
        <svg class="h-5 w-5 shrink-0 {{ $style['icon'] }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $iconPath }}" />
        </svg>
    @endif

    <div class="flex-1">{{ $slot }}</div>

    @if($dismissible)
        <button type="button" data-dismiss="alert" class="shrink-0 rounded-md p-1 hover:bg-black/5 dark:hover:bg-white/10 transition-colors" aria-label="Tutup">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    @endif
</div>