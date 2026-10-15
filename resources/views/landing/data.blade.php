@extends('layouts.home')

@section('title', $judul . ' - SIMADIK')

@section('content')

    {{-- Header halaman --}}
    <section class="bg-linear-to-b from-blue-950 to-blue-800 text-white">
        <div class="mx-auto max-w-6xl px-4 py-10 sm:py-14">
            <a href="{{ route('home') }}#statistik"
                class="inline-flex items-center gap-1 text-sm text-blue-200 transition hover:text-white">
                <i class="bi bi-arrow-left"></i> Kembali ke beranda
            </a>
            <div class="mt-4 flex items-center gap-4">
                <span
                    class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-white/15 text-2xl ring-1 ring-white/30 sm:h-14 sm:w-14 sm:text-3xl">
                    <i class="bi {{ $ikon }}"></i>
                </span>
                <div class="min-w-0">
                    <h1 class="truncate text-2xl font-extrabold sm:text-3xl">{{ $judul }}</h1>
                    <p class="text-sm text-blue-100">
                        {{ number_format($paginator->total(), 0, ',', '.') }} data tercatat
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-6xl px-4 py-8 sm:py-10">

        {{-- Info privasi --}}
        <x-alert type="info" class="mb-6">
            Untuk menjaga privasi, data pribadi seperti NIK, NIP, alamat, dan tanggal lahir tidak ditampilkan.
        </x-alert>

        {{-- Filter jenis (khusus pegawai) --}}
        @if ($tabs)
            <div class="mb-4 flex flex-wrap gap-2">
                @foreach ($tabs as $tab)
                    <a href="{{ $tab['url'] }}"
                        class="rounded-full px-4 py-1.5 text-sm font-medium transition {{ $tab['aktif'] ? 'bg-blue-600 text-white' : 'bg-white text-gray-600 ring-1 ring-gray-200 hover:bg-blue-50 hover:text-blue-600 dark:bg-gray-800 dark:text-gray-300 dark:ring-gray-700 dark:hover:bg-gray-700' }}">
                        {{ $tab['label'] }}
                    </a>
                @endforeach
            </div>
        @endif

        {{-- Pencarian --}}
        <form method="GET" action="{{ url()->current() }}" class="mb-4 flex gap-2">
            @if ($jenis)
                <input type="hidden" name="jenis" value="{{ $jenis }}">
            @endif
            <div class="relative flex-1">
                <i class="bi bi-search pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                <input type="search" name="q" value="{{ $cari }}" placeholder="Cari nama..."
                    class="w-full rounded-lg border border-gray-300 bg-white py-2.5 pl-10 pr-3 text-base text-gray-800 placeholder-gray-400 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/30 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
            </div>
            <x-button type="submit">Cari</x-button>
            @if ($cari !== '')
                <x-button href="{{ url()->current() . ($jenis ? '?jenis=' . $jenis : '') }}"
                    variant="light">Reset</x-button>
            @endif
        </form>

        {{-- Tabel --}}
        <x-table striped hover>
            <x-slot:head>
                <tr>
                    <x-table.heading>No</x-table.heading>
                    @foreach ($head as $judulKolom)
                        <x-table.heading>{{ $judulKolom }}</x-table.heading>
                    @endforeach
                </tr>
            </x-slot:head>

            @forelse ($rows as $i => $baris)
                <x-table.row>
                    <x-table.cell>{{ $paginator->firstItem() + $i }}</x-table.cell>
                    @foreach ($baris as $isi)
                        <x-table.cell>{{ $isi }}</x-table.cell>
                    @endforeach
                </x-table.row>
            @empty
                <x-table.empty :colspan="count($head) + 1" message="Data tidak ditemukan." />
            @endforelse
        </x-table>

        <x-pagination :paginator="$paginator" class="mt-4" />
    </section>

@endsection
