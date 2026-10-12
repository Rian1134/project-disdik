@extends('layouts.user')

@section('title', 'Detail Siswa')

@section('content')
    @php
        $isi = fn($nilai) => filled($nilai) ? $nilai : '-';

        $panel = [
            [
                'bi-person-vcard',
                'Data Siswa',
                [
                    ['Nama Siswa', $siswa->nama_siswa],
                    ['NIK', $siswa->nik],
                    ['NISN', $siswa->nisn],
                    ['Kelas', $siswa->kelas],
                    ['Jenis Kelamin', $siswa->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan'],
                    ['Tempat Lahir', $siswa->tempat_lahir],
                    ['Tanggal Lahir', $siswa->tanggal_lahir?->translatedFormat('d F Y')],
                    ['Alamat Tempat Tinggal', $siswa->alamat],
                    ['Status Tempat Tinggal', $siswa->status_tempat_tinggal],
                    ['Status Pelajar', $siswa->status_pelajar],
                ],
            ],
            [
                'bi-people',
                'Orang Tua',
                [
                    ['Nama Ayah', $siswa->nama_ayah],
                    ['Nama Ibu', $siswa->nama_ibu],
                    ['Pekerjaan Ayah', $siswa->pekerjaan_ayah],
                    ['Pekerjaan Ibu', $siswa->pekerjaan_ibu],
                    ['Penghasilan Ayah', $siswa->kisaran_penghasilan_ayah],
                    ['Penghasilan Ibu', $siswa->kisaran_penghasilan_ibu],
                ],
            ],
            [
                'bi-info-circle',
                'Lainnya',
                [
                    ['Jumlah Saudara Kandung', $siswa->jumlah_saudara],
                    ['Jenis Bantuan Pendidikan', $siswa->bantuan_pendidikan],
                    ['Ditambahkan Pada', $siswa->created_at?->translatedFormat('d F Y H:i')],
                    ['Terakhir Diperbarui', $siswa->updated_at?->translatedFormat('d F Y H:i')],
                ],
            ],
        ];
    @endphp

    <x-card>
        <x-slot:header>
            <span class="font-semibold">Detail Siswa</span>
        </x-slot:header>

        {{-- ===== Ringkasan siswa ===== --}}
        <div class="mb-6 flex flex-wrap items-center gap-4 rounded-xl border border-gray-200 p-4 dark:border-gray-700">
            <span
                class="inline-flex h-16 w-16 shrink-0 items-center justify-center rounded-full bg-emerald-600 text-2xl font-semibold text-white">
                {{ mb_strtoupper(mb_substr($siswa->nama_siswa, 0, 1)) }}
            </span>
            <div class="min-w-0">
                <h2 class="truncate text-lg font-semibold text-gray-800 dark:text-gray-100">{{ $siswa->nama_siswa }}</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    NISN {{ $siswa->nisn }} &middot; NIK {{ $siswa->nik }}
                </p>
                <div class="mt-2 flex flex-wrap gap-1.5">
                    <x-badge variant="secondary" pill>Kelas {{ $siswa->kelas }}</x-badge>
                    <x-badge :variant="$siswa->status_pelajar === 'Aktif' ? 'success' : 'secondary'" pill>{{ $siswa->status_pelajar }}</x-badge>
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
                <x-button href="{{ route('user.siswa.index') }}" variant="light">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </x-button>
                <x-button href="{{ route('user.siswa.edit', $siswa) }}">
                    <i class="bi bi-pencil-fill me-1"></i> Edit
                </x-button>
            </div>
        </x-slot:footer>
    </x-card>
@endsection
