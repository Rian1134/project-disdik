@extends('layouts.user')

@section('title', 'Detail Pegawai')

@section('content')
    @php
        $isi = fn($nilai) => filled($nilai) ? $nilai : '-';

        $panel = [
            [
                'bi-person-vcard',
                'Data Pribadi',
                [
                    ['Nama Lengkap', $pegawai->nama],
                    ['NIK', $pegawai->nik],
                    ['NIP/NIPPPK/NIPPPKPW', $pegawai->nip],
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

    <x-card>
        <x-slot:header>
            <span class="font-semibold">Detail Pegawai</span>
        </x-slot:header>

        {{-- ===== Ringkasan pegawai ===== --}}
        <div class="mb-6 flex flex-wrap items-center gap-4 rounded-xl border border-gray-200 p-4 dark:border-gray-700">
            <span
                class="inline-flex h-16 w-16 shrink-0 items-center justify-center rounded-full bg-emerald-600 text-2xl font-semibold text-white">
                {{ mb_strtoupper(mb_substr($pegawai->nama, 0, 1)) }}
            </span>
            <div class="min-w-0">
                <h2 class="truncate text-lg font-semibold text-gray-800 dark:text-gray-100">{{ $pegawai->nama }}</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    NIP {{ $isi($pegawai->nip) }} &middot; NIK {{ $pegawai->nik }}
                </p>
                <div class="mt-2 flex flex-wrap gap-1.5">
                    <x-badge variant="success" pill>{{ $pegawai->jabatan }}</x-badge>
                    <x-badge variant="secondary" pill>{{ $pegawai->status_kepegawaian }}</x-badge>
                </div>
            </div>
        </div>

        {{-- ===== Detail ===== --}}
        <div class="grid grid-cols-1 gap-4 lg:grid-cols-3">
            @foreach ($panel as [$ikon, $judul, $baris])
                <div class="rounded-xl border border-gray-200 p-4 dark:border-gray-700">
                    <h3 class="mb-2 flex items-center gap-2 font-semibold">
                        <i class="bi {{ $ikon }} text-emerald-600 dark:text-emerald-400"></i> {{ $judul }}
                    </h3>
                    <dl class="divide-y divide-gray-200 text-sm dark:divide-gray-700">
                        @foreach ($baris as [$label, $nilai])
                            <div class="flex justify-between gap-4 py-2">
                                <dt class="text-gray-500 dark:text-gray-400">{{ $label }}</dt>
                                <dd class="text-right font-medium">{{ $isi($nilai) }}</dd>
                            </div>
                        @endforeach
                    </dl>
                </div>
            @endforeach
        </div>

        <x-slot:footer>
            <div class="flex justify-end gap-2">
                <x-button href="{{ route('user.pegawai.index') }}" variant="light">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </x-button>
                <x-button href="{{ route('user.pegawai.edit', $pegawai) }}">
                    <i class="bi bi-pencil-fill me-1"></i> Edit
                </x-button>
            </div>
        </x-slot:footer>
    </x-card>
@endsection
