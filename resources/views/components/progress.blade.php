{{--
    Komponen: Progress
    Fungsi: Menampilkan bar kemajuan proses (upload, loading, dll).

    Props:
    - value    : integer 0-100, nilai progress saat ini (default: 0)
    - variant  : primary | success | danger | warning | info (default: primary)
    - striped  : boolean, tampilkan garis diagonal (default: false)
    - animated : boolean, animasi bergerak pada garis (butuh striped=true) (default: false)
    - label    : boolean, tampilkan teks persentase di dalam bar (default: false)

    Contoh:
    <x-progress :value="65" variant="success" label />
    <x-progress :value="40" striped animated />
--}}
@props([
    'value' => 0,
    'variant' => 'primary',
    'striped' => false,
    'animated' => false,
    'label' => false,
])

@php
    $value = max(0, min(100, (int) $value));
    $variants = [
        'primary' => 'bg-blue-600',
        'success' => 'bg-emerald-600',
        'danger'  => 'bg-red-600',
        'warning' => 'bg-yellow-500',
        'info'    => 'bg-indigo-500',
    ];
    $barColor = $variants[$variant] ?? $variants['primary'];
@endphp

<div {{ $attributes->class(['w-full h-4 rounded-full bg-gray-200 dark:bg-gray-700 overflow-hidden']) }} role="progressbar" aria-valuenow="{{ $value }}" aria-valuemin="0" aria-valuemax="100">
    <div
        class="h-full flex items-center justify-center text-[10px] font-medium text-white transition-all duration-300 ease-out {{ $barColor }}
        {{ $striped ? 'bg-[length:1rem_1rem] bg-[linear-gradient(45deg,rgba(255,255,255,.15)_25%,transparent_25%,transparent_50%,rgba(255,255,255,.15)_50%,rgba(255,255,255,.15)_75%,transparent_75%,transparent)]' : '' }}
        {{ $animated ? 'animate-[progress-stripes_1s_linear_infinite]' : '' }}"
        style="width: {{ $value }}%"
    >
        @if($label)
            {{ $value }}%
        @endif
    </div>
</div>
