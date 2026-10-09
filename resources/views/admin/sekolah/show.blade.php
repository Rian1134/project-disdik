@extends('layouts.admin')

@section('title', 'Detail Sekolah')

@section('content')
    <x-breadcrumb :items="[
        ['label' => 'Data Sekolah', 'url' => route('admin.sekolah.index')],
        ['label' => $sekolah->nama_sekolah],
    ]" />

    {{-- ===== Header sekolah ===== --}}
    <x-card>
        <div class="flex flex-col gap-4 border-l-4 border-indigo-500 pl-4 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex min-w-0 items-center gap-3">
                <x-avatar :name="$sekolah->nama_sekolah" size="lg" rounded="md" />
                <div class="min-w-0">
                    <h2 class="truncate text-lg font-bold text-indigo-700 dark:text-indigo-300">{{ $sekolah->nama_sekolah }}</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">NPSN {{ $sekolah->npsn }} &middot; NSS
                        {{ $sekolah->nss }}</p>
                    <div class="mt-1 flex flex-wrap gap-1">
                        <x-badge :variant="$sekolah->status_sekolah === 'Negeri' ? 'primary' : 'warning'" pill>{{ $sekolah->status_sekolah }}</x-badge>
                        <x-badge variant="success" pill>Akreditasi {{ $sekolah->akreditasi }}</x-badge>
                    </div>
                </div>
            </div>
            <div class="flex gap-2">
                <x-button href="{{ route('admin.sekolah.index') }}" variant="light"
                    class="flex-1 sm:flex-none">Kembali</x-button>
                <x-button href="{{ route('admin.sekolah.edit', $sekolah) }}" class="flex-1 sm:flex-none">
                    <i class="bi bi-pencil-fill me-1"></i> Edit
                </x-button>
            </div>
        </div>
    </x-card>

    {{-- ===== Ringkasan jumlah ===== --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
        <x-card>
            <div class="flex items-center gap-3">
                <span
                    class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-lg border border-indigo-200 bg-indigo-100 text-lg text-indigo-600 dark:border-indigo-500/30 dark:bg-indigo-500/20 dark:text-indigo-300">
                    <i class="bi bi-people"></i>
                </span>
                <div class="min-w-0">
                    <p class="truncate text-xs text-gray-500 dark:text-gray-400">Jumlah Siswa</p>
                    <p class="text-2xl font-bold text-indigo-600 dark:text-indigo-300">{{ $sekolah->siswas_count }}</p>
                </div>
            </div>
        </x-card>
        <x-card>
            <div class="flex items-center gap-3">
                <span
                    class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-lg border border-emerald-200 bg-emerald-100 text-lg text-emerald-600 dark:border-emerald-500/30 dark:bg-emerald-500/20 dark:text-emerald-300">
                    <i class="bi bi-person-workspace"></i>
                </span>
                <div class="min-w-0">
                    <p class="truncate text-xs text-gray-500 dark:text-gray-400">Guru (Tenaga Pendidik)</p>
                    <p class="text-2xl font-bold text-emerald-600 dark:text-emerald-300">{{ $guru }}</p>
                </div>
            </div>
        </x-card>
        <x-card>
            <div class="flex items-center gap-3">
                <span
                    class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-lg border border-amber-200 bg-amber-100 text-lg text-amber-600 dark:border-amber-500/30 dark:bg-amber-500/20 dark:text-amber-300">
                    <i class="bi bi-person-badge"></i>
                </span>
                <div class="min-w-0">
                    <p class="truncate text-xs text-gray-500 dark:text-gray-400">TU (Tenaga Kependidikan)</p>
                    <p class="text-2xl font-bold text-amber-600 dark:text-amber-300">{{ $tu }}</p>
                </div>
            </div>
        </x-card>
    </div>

    {{-- ===== Detail ===== --}}
    <div class="grid grid-cols-1 gap-4 lg:grid-cols-3">
        <x-card>
            <x-slot:header>
                <span class="font-semibold"><i class="bi bi-building me-2 text-indigo-600 dark:text-indigo-400"></i>Identitas Sekolah</span>
            </x-slot:header>

            <dl class="divide-y divide-gray-200 text-sm dark:divide-gray-700">
                <div class="flex justify-between gap-4 py-2">
                    <dt class="text-slate-500 dark:text-slate-400">Nama Sekolah</dt>
                    <dd class="text-right font-medium">{{ $sekolah->nama_sekolah }}</dd>
                </div>
                <div class="flex justify-between gap-4 py-2">
                    <dt class="text-slate-500 dark:text-slate-400">Nomor Statistik Sekolah</dt>
                    <dd class="text-right font-medium">{{ $sekolah->nss }}</dd>
                </div>
                <div class="flex justify-between gap-4 py-2">
                    <dt class="text-slate-500 dark:text-slate-400">Nomor Pokok Sekolah Nasional</dt>
                    <dd class="text-right font-medium">{{ $sekolah->npsn }}</dd>
                </div>
                <div class="flex justify-between gap-4 py-2">
                    <dt class="text-slate-500 dark:text-slate-400">Nama Kepala Sekolah</dt>
                    <dd class="text-right font-medium">{{ $sekolah->nama_kepala_sekolah }}</dd>
                </div>
                <div class="flex justify-between gap-4 py-2">
                    <dt class="text-slate-500 dark:text-slate-400">Status Akreditasi</dt>
                    <dd class="text-right font-medium">{{ $sekolah->akreditasi }}</dd>
                </div>
                <div class="flex justify-between gap-4 py-2">
                    <dt class="text-slate-500 dark:text-slate-400">Status Kepemilikan</dt>
                    <dd class="text-right font-medium">{{ $sekolah->status_sekolah }}</dd>
                </div>
                <div class="flex justify-between gap-4 py-2">
                    <dt class="text-slate-500 dark:text-slate-400">Tanggal SK Pendirian</dt>
                    <dd class="text-right font-medium">{{ $sekolah->tanggal_sk_pendirian }}</dd>
                </div>
                <div class="flex justify-between gap-4 py-2">
                    <dt class="text-slate-500 dark:text-slate-400">Tanggal SK Izin Operasional</dt>
                    <dd class="text-right font-medium">{{ $sekolah->tanggal_sk_izin_oprasional }}</dd>
                </div>
                <div class="flex justify-between gap-4 py-2">
                    <dt class="text-slate-500 dark:text-slate-400">Implementasi Kurikulum</dt>
                    <dd class="text-right font-medium">{{ $sekolah->implementasi_kurikulum }}</dd>
                </div>
            </dl>
        </x-card>

        <x-card>
            <x-slot:header>
                <span class="font-semibold"><i class="bi bi-geo-alt me-2 text-emerald-600 dark:text-emerald-400"></i>Alamat</span>
            </x-slot:header>

            <dl class="divide-y divide-gray-200 text-sm dark:divide-gray-700">
                <div class="flex justify-between gap-4 py-2">
                    <dt class="text-slate-500 dark:text-slate-400">Alamat</dt>
                    <dd class="text-right font-medium">{{ $sekolah->alamat }}</dd>
                </div>
                <div class="flex justify-between gap-4 py-2">
                    <dt class="text-slate-500 dark:text-slate-400">RT/RW</dt>
                    <dd class="text-right font-medium">{{ $sekolah->rt_rw }}</dd>
                </div>
                <div class="flex justify-between gap-4 py-2">
                    <dt class="text-slate-500 dark:text-slate-400">Desa/Kelurahan</dt>
                    <dd class="text-right font-medium">{{ $sekolah->desa_kelurahan }}</dd>
                </div>
                <div class="flex justify-between gap-4 py-2">
                    <dt class="text-slate-500 dark:text-slate-400">Kecamatan</dt>
                    <dd class="text-right font-medium">{{ $sekolah->kecamatan }}</dd>
                </div>
                <div class="flex justify-between gap-4 py-2">
                    <dt class="text-slate-500 dark:text-slate-400">Kabupaten</dt>
                    <dd class="text-right font-medium">{{ $sekolah->kabupaten }}</dd>
                </div>
                <div class="flex justify-between gap-4 py-2">
                    <dt class="text-slate-500 dark:text-slate-400">Provinsi</dt>
                    <dd class="text-right font-medium">{{ $sekolah->provinsi }}</dd>
                </div>
                <div class="flex justify-between gap-4 py-2">
                    <dt class="text-slate-500 dark:text-slate-400">Kode Pos</dt>
                    <dd class="text-right font-medium">{{ $sekolah->kode_pos }}</dd>
                </div>
            </dl>
        </x-card>

        <x-card>
            <x-slot:header>
                <span class="font-semibold"><i class="bi bi-lightning-charge me-2 text-amber-500"></i>Sarana Pendukung</span>
            </x-slot:header>

            <dl class="divide-y divide-gray-200 text-sm dark:divide-gray-700">
                <div class="flex justify-between gap-4 py-2">
                    <dt class="text-slate-500 dark:text-slate-400">Luas Tanah</dt>
                    <dd class="text-right font-medium">{{ $sekolah->laus_tanah . ' m²' }}</dd>
                </div>
                <div class="flex justify-between gap-4 py-2">
                    <dt class="text-slate-500 dark:text-slate-400">Luas Bangunan</dt>
                    <dd class="text-right font-medium">{{ $sekolah->laus_bangunan . ' m²' }}</dd>
                </div>
                <div class="flex justify-between gap-4 py-2">
                    <dt class="text-slate-500 dark:text-slate-400">Tipe Internet</dt>
                    <dd class="text-right font-medium">{{ $sekolah->tipe_internet ?? '-' }}</dd>
                </div>
                <div class="flex justify-between gap-4 py-2">
                    <dt class="text-slate-500 dark:text-slate-400">Provider Internet</dt>
                    <dd class="text-right font-medium">{{ $sekolah->internet_provider ?? '-' }}</dd>
                </div>
                <div class="flex justify-between gap-4 py-2">
                    <dt class="text-slate-500 dark:text-slate-400">Bandwidth Internet</dt>
                    <dd class="text-right font-medium">
                        {{ $sekolah->bandwith_internet ? $sekolah->bandwith_internet . ' Mbps' : '-' }}</dd>
                </div>
                <div class="flex justify-between gap-4 py-2">
                    <dt class="text-slate-500 dark:text-slate-400">Sumber Listrik</dt>
                    <dd class="text-right font-medium">{{ $sekolah->sumber_listrik ?? '-' }}</dd>
                </div>
                <div class="flex justify-between gap-4 py-2">
                    <dt class="text-slate-500 dark:text-slate-400">Daya Listrik</dt>
                    <dd class="text-right font-medium">{{ $sekolah->daya_listrik ? $sekolah->daya_listrik . ' VA' : '-' }}
                    </dd>
                </div>
                <div class="flex justify-between gap-4 py-2">
                    <dt class="text-slate-500 dark:text-slate-400">Sumber Air</dt>
                    <dd class="text-right font-medium">{{ $sekolah->sumber_air ?? '-' }}</dd>
                </div>
            </dl>
        </x-card>
    </div>

    <x-card>
        <x-slot:header>
            <span class="font-semibold"><i class="bi bi-file-earmark-text me-2 text-rose-500"></i>Dokumen SK</span>
        </x-slot:header>

        <dl class="divide-y divide-gray-200 text-sm dark:divide-gray-700">
            <div class="flex items-center justify-between gap-4 py-2">
                <dt class="text-slate-500 dark:text-slate-400">SK Pendirian Sekolah</dt>
                <dd>
                    <x-button href="#" size="xs" target="_blank">
                        <i class="bi bi-box-arrow-up-right me-1"></i> Lihat SK
                    </x-button>
                </dd>
            </div>
            <div class="flex items-center justify-between gap-4 py-2">
                <dt class="text-slate-500 dark:text-slate-400">SK Izin Operasional</dt>
                <dd>
                    <x-button href="#" size="xs" target="_blank">
                        <i class="bi bi-box-arrow-up-right me-1"></i> Lihat SK
                    </x-button>
                </dd>
            </div>
            <div class="flex items-center justify-between gap-4 py-2">
                <dt class="text-slate-500 dark:text-slate-400">SK Akreditasi Sekolah</dt>
                <dd>
                    <x-button href="#" size="xs" target="_blank">
                        <i class="bi bi-box-arrow-up-right me-1"></i> Lihat SK
                    </x-button>
                </dd>
            </div>
        </dl>
    </x-card>
@endsection