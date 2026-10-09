@extends('layouts.admin')

@section('title', 'Detail Pegawai')

@section('content')
    @php
        $laki = $pegawai->jenis_kelamin === 'L';

        $warnaStatus = [
            'PNS' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-300',
            'PPPK' => 'bg-sky-100 text-sky-700 dark:bg-sky-500/20 dark:text-sky-300',
            'PPPK Paruh Waktu' => 'bg-cyan-100 text-cyan-700 dark:bg-cyan-500/20 dark:text-cyan-300',
            'Non-ASN' => 'bg-amber-100 text-amber-700 dark:bg-amber-500/20 dark:text-amber-300',
            'Honorer' => 'bg-orange-100 text-orange-700 dark:bg-orange-500/20 dark:text-orange-300',
        ];
        $warnaStatusLain = 'bg-slate-100 text-slate-600 dark:bg-slate-500/20 dark:text-slate-300';

        // Tiap kelompok = satu kartu. Tambah / ubah baris cukup di sini.
        $kelompok = [
            [
                'judul' => 'Identitas Pegawai',
                'ikon' => 'bi-person-vcard-fill',
                'warna' => 'text-indigo-600 dark:text-indigo-400',
                'baris' => [
                    ['Nama Lengkap', $pegawai->nama],
                    ['NIK', $pegawai->nik],
                    ['NIP/NIPPPK/NIPPPKPW', $pegawai->nip],
                    ['Jenis Kelamin', $laki ? 'Laki-laki' : 'Perempuan'],
                    ['Agama', $pegawai->agama],
                ],
            ],
            [
                'judul' => 'Kelahiran & Alamat',
                'ikon' => 'bi-geo-alt-fill',
                'warna' => 'text-emerald-600 dark:text-emerald-400',
                'baris' => [
                    ['Sekolah', $pegawai->sekolah->nama_sekolah],
                    ['Tempat Lahir', $pegawai->tempat_lahir],
                    ['Tanggal Lahir', $pegawai->tanggal_lahir?->translatedFormat('d F Y')],
                    ['Alamat Tempat Tinggal', $pegawai->alamat],
                ],
            ],
            [
                'judul' => 'Kepegawaian',
                'ikon' => 'bi-briefcase-fill',
                'warna' => 'text-amber-500',
                'baris' => [
                    ['Golongan', $pegawai->golongan],
                    ['Pangkat', $pegawai->pangkat],
                    ['TMT di Sekolah Ini', $pegawai->terhitung_mulai_tanggal?->translatedFormat('d F Y')],
                    ['Jabatan', $pegawai->jabatan],
                    ['Tugas', $pegawai->tugas],
                    ['Status Kepegawaian', $pegawai->status_kepegawaian],
                ],
            ],
            [
                'judul' => 'Pendidikan',
                'ikon' => 'bi-mortarboard-fill',
                'warna' => 'text-sky-500',
                'baris' => [
                    ['Pendidikan Terakhir', $pegawai->pendidikan_terakhir],
                    ['Unit Satuan Pendidikan Terakhir', $pegawai->unit_satuan_pendidikan_terakhir],
                    ['Ditambahkan Pada', $pegawai->created_at?->translatedFormat('d F Y H:i')],
                    ['Terakhir Diperbarui', $pegawai->updated_at?->translatedFormat('d F Y H:i')],
                ],
            ],
        ];
    @endphp

    <x-breadcrumb :items="[
        ['label' => 'Data Pegawai', 'url' => route('admin.pegawai.index')],
        ['label' => $pegawai->sekolah->nama_sekolah, 'url' => route('admin.pegawai.sekolah', $pegawai->sekolah_id)],
        ['label' => $pegawai->nama],
    ]" />

    {{-- ===== Header pegawai ===== --}}
    <x-card>
        <div class="flex flex-col gap-4 border-l-4 border-indigo-500 pl-4 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex min-w-0 items-center gap-3">
                <x-avatar :name="$pegawai->nama" size="lg" rounded="md" />
                <div class="min-w-0">
                    <h2 class="truncate text-lg font-bold text-indigo-700 dark:text-indigo-300">{{ $pegawai->nama }}</h2>
                    <p class="truncate text-sm text-gray-500 dark:text-gray-400">
                        NIP {{ $pegawai->nip ?: '-' }} &middot; {{ $pegawai->tugas }}
                    </p>
                    <div class="mt-1 flex flex-wrap items-center gap-1">
                        <span
                            class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $pegawai->jabatan === 'Tenaga Pendidik' ? 'bg-indigo-100 text-indigo-700 dark:bg-indigo-500/20 dark:text-indigo-300' : 'bg-amber-100 text-amber-700 dark:bg-amber-500/20 dark:text-amber-300' }}">{{ $pegawai->jabatan }}</span>
                        <span
                            class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $warnaStatus[$pegawai->status_kepegawaian] ?? $warnaStatusLain }}">{{ $pegawai->status_kepegawaian }}</span>
                        <span
                            class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $laki ? 'bg-sky-100 text-sky-700 dark:bg-sky-500/20 dark:text-sky-300' : 'bg-rose-100 text-rose-700 dark:bg-rose-500/20 dark:text-rose-300' }}">
                            <i
                                class="bi {{ $laki ? 'bi-gender-male' : 'bi-gender-female' }} me-1"></i>{{ $laki ? 'Laki-laki' : 'Perempuan' }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="flex gap-2">
                <x-button href="{{ route('admin.pegawai.sekolah', $pegawai->sekolah_id) }}" variant="light"
                    class="flex-1 sm:flex-none">Kembali</x-button>
                <x-button href="{{ route('admin.pegawai.edit', $pegawai) }}" class="flex-1 sm:flex-none">
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
