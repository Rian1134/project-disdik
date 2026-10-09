@extends('layouts.admin')

@section('title', 'Detail Siswa')

@section('content')
    @php
        $laki = $siswa->jenis_kelamin === 'L';

        // Tiap kelompok = satu kartu. Tambah / ubah baris cukup di sini.
        $kelompok = [
            [
                'judul' => 'Identitas Siswa',
                'ikon' => 'bi-person-vcard-fill',
                'warna' => 'text-indigo-600 dark:text-indigo-400',
                'baris' => [
                    ['Nama Siswa', $siswa->nama_siswa],
                    ['NIK', $siswa->nik],
                    ['NISN', $siswa->nisn],
                    ['Kelas', $siswa->kelas],
                    ['Jenis Kelamin', $laki ? 'Laki-laki' : 'Perempuan'],
                    ['Tempat Lahir', $siswa->tempat_lahir],
                    ['Tanggal Lahir', $siswa->tanggal_lahir?->translatedFormat('d F Y')],
                ],
            ],
            [
                'judul' => 'Sekolah & Tempat Tinggal',
                'ikon' => 'bi-geo-alt-fill',
                'warna' => 'text-emerald-600 dark:text-emerald-400',
                'baris' => [
                    ['Sekolah', $siswa->sekolah->nama_sekolah],
                    ['Status Pelajar', $siswa->status_pelajar],
                    ['Alamat Tempat Tinggal', $siswa->alamat],
                    ['Status Tempat Tinggal', $siswa->status_tempat_tinggal],
                ],
            ],
            [
                'judul' => 'Orang Tua',
                'ikon' => 'bi-people-fill',
                'warna' => 'text-amber-500',
                'baris' => [
                    ['Nama Ayah', $siswa->nama_ayah],
                    ['Nama Ibu', $siswa->nama_ibu],
                    ['Pekerjaan Ayah', $siswa->pekerjaan_ayah],
                    ['Pekerjaan Ibu', $siswa->pekerjaan_ibu],
                    ['Penghasilan Ayah', $siswa->kisaran_penghasilan_ayah],
                    ['Penghasilan Ibu', $siswa->kisaran_penghasilan_ibu],
                ],
            ],
            [
                'judul' => 'Lainnya',
                'ikon' => 'bi-info-circle-fill',
                'warna' => 'text-sky-500',
                'baris' => [
                    ['Jumlah Saudara Kandung', $siswa->jumlah_saudara],
                    ['Jenis Bantuan Pendidikan', $siswa->bantuan_pendidikan],
                    ['Ditambahkan Pada', $siswa->created_at?->translatedFormat('d F Y H:i')],
                    ['Terakhir Diperbarui', $siswa->updated_at?->translatedFormat('d F Y H:i')],
                ],
            ],
        ];
    @endphp

    <x-breadcrumb :items="[
        ['label' => 'Data Siswa', 'url' => route('admin.siswa.index')],
        ['label' => $siswa->sekolah->nama_sekolah, 'url' => route('admin.siswa.sekolah', $siswa->sekolah_id)],
        ['label' => $siswa->nama_siswa],
    ]" />

    {{-- ===== Header siswa ===== --}}
    <x-card>
        <div class="flex flex-col gap-4 border-l-4 border-indigo-500 pl-4 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex min-w-0 items-center gap-3">
                <x-avatar :name="$siswa->nama_siswa" size="lg" rounded="md" />
                <div class="min-w-0">
                    <h2 class="truncate text-lg font-bold text-indigo-700 dark:text-indigo-300">{{ $siswa->nama_siswa }}</h2>
                    <p class="truncate text-sm text-gray-500 dark:text-gray-400">
                        NISN {{ $siswa->nisn }} &middot; NIK {{ $siswa->nik }}
                    </p>
                    <div class="mt-1 flex flex-wrap items-center gap-1">
                        <span
                            class="inline-flex items-center rounded-full bg-indigo-100 px-2.5 py-0.5 text-xs font-medium text-indigo-700 dark:bg-indigo-500/20 dark:text-indigo-300">
                            Kelas {{ $siswa->kelas }}
                        </span>
                        <span
                            class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $laki ? 'bg-sky-100 text-sky-700 dark:bg-sky-500/20 dark:text-sky-300' : 'bg-rose-100 text-rose-700 dark:bg-rose-500/20 dark:text-rose-300' }}">
                            <i
                                class="bi {{ $laki ? 'bi-gender-male' : 'bi-gender-female' }} me-1"></i>{{ $laki ? 'Laki-laki' : 'Perempuan' }}
                        </span>
                        <x-badge :variant="$siswa->status_pelajar === 'Aktif' ? 'success' : 'secondary'" pill>{{ $siswa->status_pelajar }}</x-badge>
                    </div>
                </div>
            </div>
            <div class="flex gap-2">
                <x-button href="{{ route('admin.siswa.sekolah', $siswa->sekolah_id) }}" variant="light"
                    class="flex-1 sm:flex-none">Kembali</x-button>
                <x-button href="{{ route('admin.siswa.edit', $siswa) }}" class="flex-1 sm:flex-none">
                    <i class="bi bi-pencil-fill me-1"></i> Edit
                </x-button>
            </div>
        </div>
    </x-card>

    {{-- ===== Detail (2 x 2) ===== --}}
    <div class="grid grid-cols-1 items-start gap-4 lg:grid-cols-2">
        @foreach ($kelompok as $k)
            <x-card>
                <x-slot:header>
                    <span class="font-semibold"><i
                            class="bi {{ $k['ikon'] }} me-2 {{ $k['warna'] }}"></i>{{ $k['judul'] }}</span>
                </x-slot:header>

                <dl class="divide-y divide-gray-200 text-sm dark:divide-gray-700">
                    @foreach ($k['baris'] as [$label, $nilai])
                        <div class="flex justify-between gap-4 py-2">
                            <dt class="shrink-0 text-slate-500 dark:text-slate-400">{{ $label }}</dt>
                            <dd class="min-w-0 wrap-break-word text-right font-medium">{{ filled($nilai) ? $nilai : '-' }}</dd>
                        </div>
                    @endforeach
                </dl>
            </x-card>
        @endforeach
    </div>
@endsection
