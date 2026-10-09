@extends('layouts.admin')

@section('title', 'Detail Sekolah')

@section('content')
<x-card>
    <x-slot:header>
        <span class="font-semibold">Detail Sekolah</span>
    </x-slot:header>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        <div>
            <h3 class="mb-2 font-semibold">Identitas Sekolah</h3>
            <dl class="divide-y divide-gray-200 text-sm dark:divide-gray-700">
                <div class="flex justify-between gap-4 py-2">
                    <dt class="text-gray-500 dark:text-gray-400">Nama Sekolah</dt>
                    <dd class="text-right font-medium">{{ $sekolah->nama_sekolah }}</dd>
                </div>
                <div class="flex justify-between gap-4 py-2">
                    <dt class="text-gray-500 dark:text-gray-400">Nomor Statistik Sekolah</dt>
                    <dd class="text-right font-medium">{{ $sekolah->nss }}</dd>
                </div>
                <div class="flex justify-between gap-4 py-2">
                    <dt class="text-gray-500 dark:text-gray-400">Nomor Pokok Sekolah Nasional</dt>
                    <dd class="text-right font-medium">{{ $sekolah->npsn }}</dd>
                </div>
                <div class="flex justify-between gap-4 py-2">
                    <dt class="text-gray-500 dark:text-gray-400">Nama Kepala Sekolah</dt>
                    <dd class="text-right font-medium">{{ $sekolah->nama_kepala_sekolah }}</dd>
                </div>
                <div class="flex justify-between gap-4 py-2">
                    <dt class="text-gray-500 dark:text-gray-400">Status Akreditasi</dt>
                    <dd class="text-right font-medium">{{ $sekolah->akreditasi }}</dd>
                </div>
                <div class="flex justify-between gap-4 py-2">
                    <dt class="text-gray-500 dark:text-gray-400">Status Kepemilikan</dt>
                    <dd class="text-right font-medium">{{ $sekolah->status_sekolah }}</dd>
                </div>
                <div class="flex justify-between gap-4 py-2">
                    <dt class="text-gray-500 dark:text-gray-400">Tanggal SK Pendirian</dt>
                    <dd class="text-right font-medium">{{ $sekolah->tanggal_sk_pendirian }}</dd>
                </div>
                <div class="flex justify-between gap-4 py-2">
                    <dt class="text-gray-500 dark:text-gray-400">Tanggal SK Izin Operasional</dt>
                    <dd class="text-right font-medium">{{ $sekolah->tanggal_sk_izin_oprasional }}</dd>
                </div>
                <div class="flex justify-between gap-4 py-2">
                    <dt class="text-gray-500 dark:text-gray-400">Implementasi Kurikulum</dt>
                    <dd class="text-right font-medium">{{ $sekolah->implementasi_kurikulum }}</dd>
                </div>
                <div class="flex justify-between gap-4 py-2">
                    <dt class="text-gray-500 dark:text-gray-400">Jumlah Siswa</dt>
                    <dd class="text-right font-medium">{{ $sekolah->siswas_count }}</dd>
                </div>
            </dl>
        </div>

        <div>
            <h3 class="mb-2 font-semibold">Alamat</h3>
            <dl class="divide-y divide-gray-200 text-sm dark:divide-gray-700">
                <div class="flex justify-between gap-4 py-2">
                    <dt class="text-gray-500 dark:text-gray-400">Alamat</dt>
                    <dd class="text-right font-medium">{{ $sekolah->alamat }}</dd>
                </div>
                <div class="flex justify-between gap-4 py-2">
                    <dt class="text-gray-500 dark:text-gray-400">RT/RW</dt>
                    <dd class="text-right font-medium">{{ $sekolah->rt_rw }}</dd>
                </div>
                <div class="flex justify-between gap-4 py-2">
                    <dt class="text-gray-500 dark:text-gray-400">Desa/Kelurahan</dt>
                    <dd class="text-right font-medium">{{ $sekolah->desa_kelurahan }}</dd>
                </div>
                <div class="flex justify-between gap-4 py-2">
                    <dt class="text-gray-500 dark:text-gray-400">Kecamatan</dt>
                    <dd class="text-right font-medium">{{ $sekolah->kecamatan }}</dd>
                </div>
                <div class="flex justify-between gap-4 py-2">
                    <dt class="text-gray-500 dark:text-gray-400">Kabupaten</dt>
                    <dd class="text-right font-medium">{{ $sekolah->kabupaten }}</dd>
                </div>
                <div class="flex justify-between gap-4 py-2">
                    <dt class="text-gray-500 dark:text-gray-400">Provinsi</dt>
                    <dd class="text-right font-medium">{{ $sekolah->provinsi }}</dd>
                </div>
                <div class="flex justify-between gap-4 py-2">
                    <dt class="text-gray-500 dark:text-gray-400">Kode Pos</dt>
                    <dd class="text-right font-medium">{{ $sekolah->kode_pos }}</dd>
                </div>
            </dl>
        </div>

        <div>
            <h3 class="mb-2 font-semibold">Sarana Pendukung</h3>
            <dl class="divide-y divide-gray-200 text-sm dark:divide-gray-700">
                <div class="flex justify-between gap-4 py-2">
                    <dt class="text-gray-500 dark:text-gray-400">Luas Tanah</dt>
                    <dd class="text-right font-medium">{{ $sekolah->laus_tanah . ' m²' }}</dd>
                </div>
                <div class="flex justify-between gap-4 py-2">
                    <dt class="text-gray-500 dark:text-gray-400">Luas Bangunan</dt>
                    <dd class="text-right font-medium">{{ $sekolah->laus_bangunan . ' m²' }}</dd>
                </div>
                <div class="flex justify-between gap-4 py-2">
                    <dt class="text-gray-500 dark:text-gray-400">Tipe Internet</dt>
                    <dd class="text-right font-medium">{{ $sekolah->tipe_internet ?? '-' }}</dd>
                </div>
                <div class="flex justify-between gap-4 py-2">
                    <dt class="text-gray-500 dark:text-gray-400">Provider Internet</dt>
                    <dd class="text-right font-medium">{{ $sekolah->internet_provider ?? '-' }}</dd>
                </div>
                <div class="flex justify-between gap-4 py-2">
                    <dt class="text-gray-500 dark:text-gray-400">Bandwidth Internet</dt>
                    <dd class="text-right font-medium">{{ $sekolah->bandwith_internet ? $sekolah->bandwith_internet . ' Mbps' : '-' }}</dd>
                </div>
                <div class="flex justify-between gap-4 py-2">
                    <dt class="text-gray-500 dark:text-gray-400">Sumber Listrik</dt>
                    <dd class="text-right font-medium">{{ $sekolah->sumber_listrik ?? '-' }}</dd>
                </div>
                <div class="flex justify-between gap-4 py-2">
                    <dt class="text-gray-500 dark:text-gray-400">Daya Listrik</dt>
                    <dd class="text-right font-medium">{{ $sekolah->daya_listrik ? $sekolah->daya_listrik . ' VA' : '-' }}</dd>
                </div>
                <div class="flex justify-between gap-4 py-2">
                    <dt class="text-gray-500 dark:text-gray-400">Sumber Air</dt>
                    <dd class="text-right font-medium">{{ $sekolah->sumber_air ?? '-' }}</dd>
                </div>
            </dl>
        </div>
    </div>

    <h3 class="mb-2 mt-6 font-semibold">Dokumen SK</h3>
    <dl class="divide-y divide-gray-200 text-sm dark:divide-gray-700">
            <div class="flex items-center justify-between gap-4 py-2">
                <dt class="text-gray-500 dark:text-gray-400">SK Pendirian Sekolah</dt>
                <dd>
                    <x-button href="#" size="xs" target="_blank">
                        <i class="bi bi-box-arrow-up-right me-1"></i> Lihat SK
                    </x-button>
                </dd>
            </div>
            <div class="flex items-center justify-between gap-4 py-2">
                <dt class="text-gray-500 dark:text-gray-400">SK Izin Operasional</dt>
                <dd>
                    <x-button href="#" size="xs" target="_blank">
                        <i class="bi bi-box-arrow-up-right me-1"></i> Lihat SK
                    </x-button>
                </dd>
            </div>
            <div class="flex items-center justify-between gap-4 py-2">
                <dt class="text-gray-500 dark:text-gray-400">SK Akreditasi Sekolah</dt>
                <dd>
                    <x-button href="#" size="xs" target="_blank">
                        <i class="bi bi-box-arrow-up-right me-1"></i> Lihat SK
                    </x-button>
                </dd>
            </div>
    </dl>

    <x-slot:footer>
        <div class="flex justify-end gap-2">
            <x-button href="{{ route('admin.sekolah.index') }}" variant="light">Kembali</x-button>
            <x-button href="{{ route('admin.sekolah.edit', $sekolah) }}">Edit</x-button>
        </div>
    </x-slot:footer>
</x-card>
@endsection