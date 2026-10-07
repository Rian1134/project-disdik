{{--
    Komponen: Breadcrumb
    Fungsi: Menampilkan jejak navigasi halaman.

    Props:
    - items : array, daftar breadcrumb. Format: [['label' => 'Beranda', 'url' => '/'], ['label' => 'Pengguna']]
              (item terakhir tanpa 'url' dianggap halaman aktif)

    Contoh:
    <x-breadcrumb :items="[
        ['label' => 'Beranda', 'url' => '/'],
        ['label' => 'Pengguna', 'url' => '/users'],
        ['label' => 'Detail'],
    ]" />
--}}
@props([
    'items' => [],
])

<nav {{ $attributes->class(['flex flex-wrap']) }} aria-label="Breadcrumb">
    <ol class="flex flex-wrap items-center gap-1.5 text-sm">
        @foreach($items as $index => $item)
            <li class="flex items-center gap-1.5">
                @if($index > 0)
                    <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                    </svg>
                @endif

                @if(!empty($item['url']) && $index < count($items) - 1)
                    <a href="{{ $item['url'] }}" class="text-gray-500 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400 transition-colors">
                        {{ $item['label'] }}
                    </a>
                @else
                    <span class="font-medium text-gray-800 dark:text-gray-100" aria-current="page">{{ $item['label'] }}</span>
                @endif
            </li>
        @endforeach
    </ol>
</nav>
