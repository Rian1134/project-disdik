{{--
    Komponen: Toast
    Fungsi: Notifikasi sementara di pojok layar. Muncul di kanan atas (desktop)
            dan lebar penuh dengan margin (mobile).

    Catatan: Komponen ini mendefinisikan SATU toast statis. Untuk memicu toast
    secara dinamis dari JavaScript, gunakan fungsi showToast() di resources/js/toast.js.
    Wajib menaruh <div id="toast-container"> sekali saja di layout utama (lihat dokumentasi).

    Props:
    - type      : success | danger | warning | info (default: info)
    - autoClose : boolean, otomatis tertutup (default: true)
    - duration  : integer, durasi ms sebelum tertutup otomatis (default: 4000)

    Contoh (statis):
    <x-toast type="success">Data berhasil disimpan!</x-toast>

    Contoh (dinamis via JS):
    showToast({ type: 'success', message: 'Berhasil disimpan!' });
--}}
@props([
    'type' => 'info',
    'autoClose' => true,
    'duration' => 4000,
])

@php
    $styles = [
        'success' => 'border-emerald-500 text-emerald-700 dark:text-emerald-300',
        'danger'  => 'border-red-500 text-red-700 dark:text-red-300',
        'warning' => 'border-yellow-500 text-yellow-700 dark:text-yellow-300',
        'info'    => 'border-indigo-500 text-indigo-700 dark:text-indigo-300',
    ];
    $style = $styles[$type] ?? $styles['info'];
@endphp

<div
    data-toast
    data-toast-autoclose="{{ $autoClose ? 'true' : 'false' }}"
    data-toast-duration="{{ $duration }}"
    role="alert"
    {{ $attributes->class([
        'flex items-center gap-3 rounded-lg border-l-4 bg-white dark:bg-gray-800 px-4 py-3 shadow-lg',
        'w-full sm:w-80',
        $style,
    ]) }}
>
    <div class="flex-1 text-sm text-gray-700 dark:text-gray-200">{{ $slot }}</div>
    <button type="button" data-dismiss="toast" class="rounded-md p-1 text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700" aria-label="Tutup">
        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>
</div>
