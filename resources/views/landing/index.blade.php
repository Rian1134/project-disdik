@extends('layouts.home')

@section('title', 'SIMADIK - Sistem Informasi Manajemen Akademik & Pendidikan')

@section('content')

    {{-- Hero --}}
    <section id="beranda" class="relative isolate flex min-h-[80vh] items-center overflow-hidden">
        {{-- Foto latar: overlay dibuat lebih tipis supaya foto gedung tetap terlihat --}}
        <img src="{{ asset('assets/img/foto-disdik.webp') }}" alt="Gedung Dinas Pendidikan dan Kebudayaan Kabupaten Lahat"
            class="absolute inset-0 -z-20 h-full w-full object-cover object-[center_40%]">
        <div class="absolute inset-0 -z-10 bg-linear-to-b from-blue-950/70 via-blue-900/50 to-blue-950/80"></div>

        <div class="mx-auto w-full max-w-4xl px-4 pb-32 pt-16 text-center text-white sm:pb-36 sm:pt-20 lg:pt-28">
            {{-- Logo --}}
            <div
                class="mx-auto flex h-24 w-24 items-center justify-center rounded-full bg-white shadow-xl ring-4 ring-white/40 sm:h-28 sm:w-28">
                <img src="{{ asset('assets/img/icon-web.webp') }}" alt="Logo Tut Wuri Handayani" width="80" height="80"
                    class="h-16 w-16 object-contain sm:h-20 sm:w-20">
            </div>

            <span
                class="mt-6 inline-flex max-w-full items-center gap-2 rounded-full bg-white/20 px-3 py-1 text-xs font-semibold backdrop-blur sm:text-sm">
                <i class="bi bi-building shrink-0"></i>
                <span class="truncate">Dinas Pendidikan dan Kebudayaan Kabupaten Lahat</span>
            </span>

            <h1 class="mt-5 text-4xl font-extrabold tracking-tight drop-shadow-lg sm:text-5xl lg:text-6xl">
                SIMADIK
            </h1>
            <p class="mt-3 text-lg font-semibold drop-shadow sm:text-xl lg:text-2xl">
                Sistem Informasi Manajemen Akademik &amp; Pendidikan
            </p>
            <p class="mx-auto mt-4 max-w-2xl text-sm text-blue-50 drop-shadow sm:text-base lg:text-lg">
                Kelola data sekolah, siswa, dan pegawai dalam satu aplikasi yang sederhana dan terintegrasi.
            </p>

            <div class="mt-8 flex flex-col items-stretch justify-center gap-3 sm:flex-row sm:items-center">
                <x-button href="{{ route('login') }}" size="lg">Masuk ke Aplikasi</x-button>
                <x-button href="#statistik" variant="light" size="lg">Lihat Statistik</x-button>
            </div>
        </div>
    </section>

    {{-- Statistik: kartu menimpa bagian bawah hero --}}
    <section id="statistik" class="relative z-10 mx-auto -mt-20 max-w-6xl scroll-mt-4 px-4 pb-14 sm:-mt-24 sm:pb-20">
        @php
            $items = [
                [
                    'label' => 'Siswa',
                    'value' => $stats['siswa'],
                    'icon' => 'bi-mortarboard-fill',
                    'color' => 'bg-blue-100 text-blue-600 dark:bg-blue-900/40 dark:text-blue-300',
                ],
                [
                    'label' => 'Tenaga Pendidik',
                    'value' => $stats['pendidik'],
                    'icon' => 'bi-person-workspace',
                    'color' => 'bg-emerald-100 text-emerald-600 dark:bg-emerald-900/40 dark:text-emerald-300',
                ],
                [
                    'label' => 'Tenaga Kependidikan',
                    'value' => $stats['kependidikan'],
                    'icon' => 'bi-person-badge-fill',
                    'color' => 'bg-amber-100 text-amber-600 dark:bg-amber-900/40 dark:text-amber-300',
                ],
                [
                    'label' => 'Sekolah',
                    'value' => $stats['sekolah'],
                    'icon' => 'bi-building-fill',
                    'color' => 'bg-violet-100 text-violet-600 dark:bg-violet-900/40 dark:text-violet-300',
                ],
            ];
        @endphp

        <div class="grid grid-cols-2 gap-3 sm:gap-6 lg:grid-cols-4">
            @foreach ($items as $item)
                <x-card class="shadow-lg transition hover:-translate-y-1 hover:shadow-xl">
                    <div class="flex flex-col items-center py-2 text-center sm:py-4">
                        <span
                            class="flex h-12 w-12 items-center justify-center rounded-full text-2xl sm:h-16 sm:w-16 sm:text-3xl {{ $item['color'] }}">
                            <i class="bi {{ $item['icon'] }}"></i>
                        </span>
                        <div class="mt-3 text-2xl font-bold sm:mt-4 sm:text-4xl">
                            {{ number_format($item['value'], 0, ',', '.') }}
                        </div>
                        <div
                            class="mt-1 text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-gray-400 sm:text-sm">
                            {{ $item['label'] }}
                        </div>
                    </div>
                </x-card>
            @endforeach
        </div>
    </section>

    {{-- Fitur --}}
    <section id="fitur" class="scroll-mt-20 bg-white py-14 dark:bg-gray-800 sm:py-20">
        <div class="mx-auto max-w-6xl px-4">
            <div class="mb-8 text-center sm:mb-12">
                <h2 class="text-2xl font-bold sm:text-3xl">Yang Bisa Dilakukan</h2>
                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400 sm:text-base">
                    Semua kebutuhan data sekolah dalam satu tempat.
                </p>
            </div>

            @php
                $fiturs = [
                    [
                        'icon' => 'bi-building',
                        'title' => 'Data Sekolah',
                        'desc' => 'Kelola profil dan informasi seluruh sekolah secara terpusat.',
                    ],
                    [
                        'icon' => 'bi-people-fill',
                        'title' => 'Data Siswa',
                        'desc' => 'Catat, impor, dan perbarui data siswa dengan mudah.',
                    ],
                    [
                        'icon' => 'bi-person-vcard-fill',
                        'title' => 'Data Pegawai',
                        'desc' => 'Kelola data guru dan tenaga kependidikan dalam satu daftar.',
                    ],
                ];
            @endphp

            <div class="grid gap-4 sm:gap-6 md:grid-cols-3">
                @foreach ($fiturs as $fitur)
                    <div class="rounded-xl border border-gray-200 p-5 text-center dark:border-gray-700 sm:p-6 md:text-left">
                        <span
                            class="mx-auto flex h-12 w-12 items-center justify-center rounded-lg bg-blue-600 text-xl text-white md:mx-0">
                            <i class="bi {{ $fitur['icon'] }}"></i>
                        </span>
                        <h3 class="mt-4 text-lg font-semibold">{{ $fitur['title'] }}</h3>
                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">{{ $fitur['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="mx-auto max-w-4xl px-4 py-14 text-center sm:py-20">
        <h2 class="text-2xl font-bold sm:text-3xl">Siap mulai mengelola data?</h2>
        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400 sm:text-base">
            Masuk dengan akun Anda untuk mengakses SIMADIK.
        </p>
        <div class="mt-6">
            <x-button href="{{ route('login') }}" size="lg">Masuk Sekarang</x-button>
        </div>
    </section>

@endsection
