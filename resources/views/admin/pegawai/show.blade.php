@extends('layouts.admin')

@section('title', 'Detail Pegawai')

@section('content')
<x-card>
    <x-slot:header>
        <span class="font-semibold">Detail Pegawai</span>
    </x-slot:header>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        <div>
            <h3 class="mb-2 font-semibold">Data Pribadi</h3>
            <dl class="divide-y divide-gray-200 text-sm dark:divide-gray-700">
                <div class="flex justify-between gap-4 py-2">
                    <dt class="text-gray-500 dark:text-gray-400">Sekolah</dt>
                    <dd class="text-right font-medium">{{ $pegawai->sekolah->nama_sekolah }}</dd>
                </div>
                <div class="flex justify-between gap-4 py-2">
                    <dt class="text-gray-500 dark:text-gray-400">Nama Lengkap</dt>
                    <dd class="text-right font-medium">{{ $pegawai->nama }}</dd>
                </div>
                <div class="flex justify-between gap-4 py-2">
                    <dt class="text-gray-500 dark:text-gray-400">NIK</dt>
                    <dd class="text-right font-medium">{{ $pegawai->nik }}</dd>
                </div>
                <div class="flex justify-between gap-4 py-2">
                    <dt class="text-gray-500 dark:text-gray-400">NIP/NIPPPK/NIPPPKPW</dt>
                    <dd class="text-right font-medium">{{ $pegawai->nip ?? '-' }}</dd>
                </div>
                <div class="flex justify-between gap-4 py-2">
                    <dt class="text-gray-500 dark:text-gray-400">Jenis Kelamin</dt>
                    <dd class="text-right font-medium">{{ $pegawai->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</dd>
                </div>
                <div class="flex justify-between gap-4 py-2">
                    <dt class="text-gray-500 dark:text-gray-400">Agama</dt>
                    <dd class="text-right font-medium">{{ $pegawai->agama }}</dd>
                </div>
                <div class="flex justify-between gap-4 py-2">
                    <dt class="text-gray-500 dark:text-gray-400">Tempat Lahir</dt>
                    <dd class="text-right font-medium">{{ $pegawai->tempat_lahir }}</dd>
                </div>
                <div class="flex justify-between gap-4 py-2">
                    <dt class="text-gray-500 dark:text-gray-400">Tanggal Lahir</dt>
                    <dd class="text-right font-medium">{{ $pegawai->tanggal_lahir->translatedFormat('d F Y') }}</dd>
                </div>
                <div class="flex justify-between gap-4 py-2">
                    <dt class="text-gray-500 dark:text-gray-400">Alamat Tempat Tinggal</dt>
                    <dd class="text-right font-medium">{{ $pegawai->alamat }}</dd>
                </div>
            </dl>
        </div>

        <div>
            <h3 class="mb-2 font-semibold">Kepegawaian</h3>
            <dl class="divide-y divide-gray-200 text-sm dark:divide-gray-700">
                <div class="flex justify-between gap-4 py-2">
                    <dt class="text-gray-500 dark:text-gray-400">Golongan</dt>
                    <dd class="text-right font-medium">{{ $pegawai->golongan ?? '-' }}</dd>
                </div>
                <div class="flex justify-between gap-4 py-2">
                    <dt class="text-gray-500 dark:text-gray-400">Pangkat</dt>
                    <dd class="text-right font-medium">{{ $pegawai->pangkat ?? '-' }}</dd>
                </div>
                <div class="flex justify-between gap-4 py-2">
                    <dt class="text-gray-500 dark:text-gray-400">TMT di Sekolah Ini</dt>
                    <dd class="text-right font-medium">{{ $pegawai->terhitung_mulai_tanggal->translatedFormat('d F Y') }}</dd>
                </div>
                <div class="flex justify-between gap-4 py-2">
                    <dt class="text-gray-500 dark:text-gray-400">Jabatan</dt>
                    <dd class="text-right font-medium">{{ $pegawai->jabatan }}</dd>
                </div>
                <div class="flex justify-between gap-4 py-2">
                    <dt class="text-gray-500 dark:text-gray-400">Tugas</dt>
                    <dd class="text-right font-medium">{{ $pegawai->tugas }}</dd>
                </div>
                <div class="flex justify-between gap-4 py-2">
                    <dt class="text-gray-500 dark:text-gray-400">Status Kepegawaian</dt>
                    <dd class="text-right font-medium">{{ $pegawai->status_kepegawaian }}</dd>
                </div>
            </dl>
        </div>

        <div>
            <h3 class="mb-2 font-semibold">Pendidikan</h3>
            <dl class="divide-y divide-gray-200 text-sm dark:divide-gray-700">
                <div class="flex justify-between gap-4 py-2">
                    <dt class="text-gray-500 dark:text-gray-400">Pendidikan Terakhir</dt>
                    <dd class="text-right font-medium">{{ $pegawai->pendidikan_terakhir }}</dd>
                </div>
                <div class="flex justify-between gap-4 py-2">
                    <dt class="text-gray-500 dark:text-gray-400">Unit Satuan Pendidikan Terakhir</dt>
                    <dd class="text-right font-medium">{{ $pegawai->unit_satuan_pendidikan_terakhir }}</dd>
                </div>
                <div class="flex justify-between gap-4 py-2">
                    <dt class="text-gray-500 dark:text-gray-400">Ditambahkan Pada</dt>
                    <dd class="text-right font-medium">{{ $pegawai->created_at->translatedFormat('d F Y H:i') }}</dd>
                </div>
                <div class="flex justify-between gap-4 py-2">
                    <dt class="text-gray-500 dark:text-gray-400">Terakhir Diperbarui</dt>
                    <dd class="text-right font-medium">{{ $pegawai->updated_at->translatedFormat('d F Y H:i') }}</dd>
                </div>
            </dl>
        </div>
    </div>

    <x-slot:footer>
        <div class="flex justify-end gap-2">
            <x-button href="{{ route('admin.pegawai.sekolah', $pegawai->sekolah_id) }}" variant="light">Kembali</x-button>
            <x-button href="{{ route('admin.pegawai.edit', $pegawai) }}">Edit</x-button>
        </div>
    </x-slot:footer>
</x-card>
@endsection