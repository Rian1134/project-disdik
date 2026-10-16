@extends('layouts.user')

@section('title', 'Detail Pegawai')

@section('content')
    @php
        $isi = fn($nilai) => filled($nilai) ? $nilai : '-';

        // Warna ikon tiap panel (kelas ditulis utuh agar terbaca Tailwind)
        $warnaPanel = [
            'text-emerald-600 dark:text-emerald-400',
            'text-violet-600 dark:text-violet-400',
            'text-sky-600 dark:text-sky-400',
        ];

        // Avatar mengikuti jenis kelamin (sama dengan di daftar)
        $warnaAvatar =
            $pegawai->jenis_kelamin === 'L'
                ? 'bg-sky-100 text-sky-700 ring-sky-300/60 dark:bg-sky-500/20 dark:text-sky-300'
                : 'bg-rose-100 text-rose-700 ring-rose-300/60 dark:bg-rose-500/20 dark:text-rose-300';

        $panel = [
            [
                'bi-person-vcard',
                'Data Pribadi',
                [
                    ['Nama Lengkap', $pegawai->nama],
                    ['NIK', $pegawai->nik],
                    ['NIP/NIPPPK', $pegawai->nip],
                    ['Jenis Kelamin', $pegawai->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan'],
                    ['Agama', $pegawai->agama],
                    ['Tempat Lahir', $pegawai->tempat_lahir],
                    ['Tanggal Lahir', $pegawai->tanggal_lahir?->translatedFormat('d F Y')],
                    ['Alamat Tempat Tinggal', $pegawai->alamat],
                ],
            ],
            [
                'bi-briefcase',
                'Kepegawaian',
                [
                    ['Golongan', $pegawai->golongan],
                    ['Pangkat', $pegawai->pangkat],
                    ['TMT di Sekolah Ini', $pegawai->terhitung_mulai_tanggal?->translatedFormat('d F Y')],
                    ['Jabatan', $pegawai->jabatan],
                    ['Tugas', $pegawai->tugas],
                    ['Mata Pelajaran', $pegawai->mata_pelajaran],
                    ['Status Kepegawaian', $pegawai->status_kepegawaian],
                ],
            ],
            [
                'bi-mortarboard',
                'Pendidikan',
                [
                    ['Pendidikan Terakhir', $pegawai->pendidikan_terakhir],
                    ['Unit Satuan Pendidikan Terakhir', $pegawai->unit_satuan_pendidikan_terakhir],
                    ['Ditambahkan Pada', $pegawai->created_at?->translatedFormat('d F Y H:i')],
                    ['Terakhir Diperbarui', $pegawai->updated_at?->translatedFormat('d F Y H:i')],
                ],
            ],
        ];
    @endphp

    {{-- ===== Ringkasan: avatar + identitas + tombol ===== --}}
    <div
        class="rounded-xl border border-gray-200 bg-linear-to-r from-emerald-50 via-white to-sky-50 p-4 dark:border-gray-800 dark:from-emerald-500/10 dark:via-gray-900 dark:to-sky-500/10 sm:p-6">
        <div class="flex flex-col items-center gap-4 text-center sm:flex-row sm:items-start sm:text-left">
            <span
                class="inline-flex h-20 w-20 shrink-0 items-center justify-center rounded-full text-3xl font-semibold shadow-md ring-2 sm:h-24 sm:w-24 sm:text-4xl {{ $warnaAvatar }}">
                {{ mb_strtoupper(mb_substr($pegawai->nama, 0, 1)) }}
            </span>

            <div class="min-w-0 flex-1">
                <h2 class="wrap-break-word text-lg font-semibold text-gray-800 dark:text-gray-100 sm:text-xl">
                    {{ $pegawai->nama }}</h2>
                <p class="mt-0.5 wrap-break-word text-sm text-gray-500 dark:text-gray-400">
                    NIP {{ $isi($pegawai->nip) }} &middot; NIK {{ $pegawai->nik }}
                </p>
                <div class="mt-2 flex flex-wrap justify-center gap-1.5 sm:justify-start">
                    <x-badge variant="success" pill>{{ $pegawai->jabatan }}</x-badge>
                    <x-badge variant="secondary" pill>{{ $pegawai->status_kepegawaian }}</x-badge>
                </div>
            </div>

            <div class="flex w-full shrink-0 gap-2 sm:w-auto">
                <x-button href="{{ route('user.pegawai.index') }}" variant="light" size="sm"
                    class="flex-1 sm:flex-none">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </x-button>
                <x-button href="{{ route('user.pegawai.edit', $pegawai) }}" size="sm" class="flex-1 sm:flex-none">
                    <i class="bi bi-pencil-fill me-1"></i> Edit
                </x-button>
            </div>
        </div>
    </div>

    {{-- ===== Detail: 1 kolom di HP, 2 di tablet, 3 di layar lebar ===== --}}
    <div class="grid grid-cols-1 items-start gap-4 md:grid-cols-2 xl:grid-cols-3">
        @foreach ($panel as [$ikon, $judulPanel, $baris])
            <x-card>
                <x-slot:header>
                    <span class="font-semibold">
                        <i class="bi {{ $ikon }} me-1 {{ $warnaPanel[$loop->index % count($warnaPanel)] }}"></i>
                        {{ $judulPanel }}
                    </span>
                </x-slot:header>

                <dl class="divide-y divide-gray-200 text-sm dark:divide-gray-700">
                    @foreach ($baris as [$label, $nilai])
                        <div class="flex flex-col gap-0.5 py-2 sm:flex-row sm:justify-between sm:gap-4">
                            <dt class="text-gray-500 dark:text-gray-400 sm:max-w-[50%] sm:shrink-0">{{ $label }}
                            </dt>
                            <dd class="min-w-0 wrap-break-word font-medium sm:text-right">{{ $isi($nilai) }}</dd>
                        </div>
                    @endforeach
                </dl>
            </x-card>
        @endforeach
    </div>
@endsection
