{{--
    Komponen: Avatar
    Fungsi: Menampilkan foto profil atau inisial nama pengguna.

    Props:
    - src    : string, url gambar (opsional)
    - name   : string, nama untuk menghasilkan inisial jika src kosong
    - size   : xs | sm | md | lg | xl (default: md)
    - status : online | offline | busy | away (opsional, menampilkan indikator status)
    - rounded: full | md (default: full)

    Contoh:
    <x-avatar src="/img/user.jpg" size="lg" status="online" />
    <x-avatar name="Budi Santoso" size="md" />
--}}
@props([
    'src' => null,
    'name' => '',
    'size' => 'md',
    'status' => null,
    'rounded' => 'full',
])

@php
    $sizes = [
        'xs' => 'h-6 w-6 text-[10px]',
        'sm' => 'h-8 w-8 text-xs',
        'md' => 'h-10 w-10 text-sm',
        'lg' => 'h-14 w-14 text-lg',
        'xl' => 'h-20 w-20 text-2xl',
    ];
    $statusColor = [
        'online'  => 'bg-emerald-500',
        'offline' => 'bg-gray-400',
        'busy'    => 'bg-red-500',
        'away'    => 'bg-yellow-500',
    ];
    $initials = collect(explode(' ', trim($name)))
        ->filter()
        ->take(2)
        ->map(fn ($word) => mb_strtoupper(mb_substr($word, 0, 1)))
        ->implode('');
    $sizeClass = $sizes[$size] ?? $sizes['md'];
    $roundedClass = $rounded === 'md' ? 'rounded-md' : 'rounded-full';
@endphp

<span class="relative inline-flex flex-shrink-0">
    @if($src)
        <img src="{{ $src }}" alt="{{ $name }}" {{ $attributes->class(['object-cover', $sizeClass, $roundedClass]) }} />
    @else
        <span {{ $attributes->class(['inline-flex items-center justify-center font-medium bg-blue-100 text-blue-700 dark:bg-blue-900/50 dark:text-blue-300', $sizeClass, $roundedClass]) }}>
            {{ $initials ?: '?' }}
        </span>
    @endif

    @if($status)
        <span class="absolute bottom-0 right-0 block h-2.5 w-2.5 rounded-full ring-2 ring-white dark:ring-gray-800 {{ $statusColor[$status] ?? 'bg-gray-400' }}"></span>
    @endif
</span>
