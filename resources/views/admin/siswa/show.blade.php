@extends('layouts.admin')

@section('title', 'Detail Siswa')

@section('content')
<x-card>
    <x-slot:header>
        <span class="font-semibold">Detail Siswa</span>
    </x-slot:header>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        <div>
            <h3 class="mb-2 font-semibold">Data Siswa</h3>
            <dl class="divide-y divide-gray-200 text-sm dark:divide-gray-700">
                <div class="flex justify-between gap-4 py-2">
                    <dt class="text-gray-500 dark:text-gray-400">Sekolah</dt>
                    <dd class="text-right font-medium">{{ $siswa->sekolah->nama_sekolah }}</dd>
                </div>
                <div class="flex justify-between gap-4 py-2">
                    <dt class="text-gray-500 dark:text-gray-400">Nama Siswa</dt>
                    <dd class="text-right font-medium">{{ $siswa->nama_siswa }}</dd>
                </div>
                <div class="flex justify-between gap-4 py-2">
                    <dt class="text-gray-500 dark:text-gray-400">NIK</dt>
                    <dd class="text-right font-medium">{{ $siswa->nik }}</dd>
                </div>
                <div class="flex justify-between gap-4 py-2">
                    <dt class="text-gray-500 dark:text-gray-400">NISN</dt>
                    <dd class="text-right font-medium">{{ $siswa->nisn }}</dd>
                </div>
                <div class="flex justify-between gap-4 py-2">
                    <dt class="text-gray-500 dark:text-gray-400">Kelas</dt>
                    <dd class="text-right font-medium">{{ $siswa->kelas }}</dd>
                </div>
                <div class="flex justify-between gap-4 py-2">
                    <dt class="text-gray-500 dark:text-gray-400">Jenis Kelamin</dt>
                    <dd class="text-right font-medium">{{ $siswa->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</dd>
                </div>
                <div class="flex justify-between gap-4 py-2">
                    <dt class="text-gray-500 dark:text-gray-400">Tempat Lahir</dt>
                    <dd class="text-right font-medium">{{ $siswa->tempat_lahir }}</dd>
                </div>
                <div class="flex justify-between gap-4 py-2">
                    <dt class="text-gray-500 dark:text-gray-400">Tanggal Lahir</dt>
                    <dd class="text-right font-medium">{{ $siswa->tanggal_lahir->translatedFormat('d F Y') }}</dd>
                </div>
                <div class="flex justify-between gap-4 py-2">
                    <dt class="text-gray-500 dark:text-gray-400">Alamat Tempat Tinggal</dt>
                    <dd class="text-right font-medium">{{ $siswa->alamat }}</dd>
                </div>
                <div class="flex justify-between gap-4 py-2">
                    <dt class="text-gray-500 dark:text-gray-400">Status Tempat Tinggal</dt>
                    <dd class="text-right font-medium">{{ $siswa->status_tempat_tinggal }}</dd>
                </div>
                <div class="flex justify-between gap-4 py-2">
                    <dt class="text-gray-500 dark:text-gray-400">Status Pelajar</dt>
                    <dd class="text-right font-medium">{{ $siswa->status_pelajar }}</dd>
                </div>
            </dl>
        </div>

        <div>
            <h3 class="mb-2 font-semibold">Orang Tua</h3>
            <dl class="divide-y divide-gray-200 text-sm dark:divide-gray-700">
                <div class="flex justify-between gap-4 py-2">
                    <dt class="text-gray-500 dark:text-gray-400">Nama Ayah</dt>
                    <dd class="text-right font-medium">{{ $siswa->nama_ayah }}</dd>
                </div>
                <div class="flex justify-between gap-4 py-2">
                    <dt class="text-gray-500 dark:text-gray-400">Nama Ibu</dt>
                    <dd class="text-right font-medium">{{ $siswa->nama_ibu }}</dd>
                </div>
                <div class="flex justify-between gap-4 py-2">
                    <dt class="text-gray-500 dark:text-gray-400">Pekerjaan Ayah</dt>
                    <dd class="text-right font-medium">{{ $siswa->pekerjaan_ayah }}</dd>
                </div>
                <div class="flex justify-between gap-4 py-2">
                    <dt class="text-gray-500 dark:text-gray-400">Pekerjaan Ibu</dt>
                    <dd class="text-right font-medium">{{ $siswa->pekerjaan_ibu }}</dd>
                </div>
                <div class="flex justify-between gap-4 py-2">
                    <dt class="text-gray-500 dark:text-gray-400">Penghasilan Ayah</dt>
                    <dd class="text-right font-medium">{{ $siswa->kisaran_penghasilan_ayah }}</dd>
                </div>
                <div class="flex justify-between gap-4 py-2">
                    <dt class="text-gray-500 dark:text-gray-400">Penghasilan Ibu</dt>
                    <dd class="text-right font-medium">{{ $siswa->kisaran_penghasilan_ibu }}</dd>
                </div>
            </dl>
        </div>

        <div>
            <h3 class="mb-2 font-semibold">Lainnya</h3>
            <dl class="divide-y divide-gray-200 text-sm dark:divide-gray-700">
                <div class="flex justify-between gap-4 py-2">
                    <dt class="text-gray-500 dark:text-gray-400">Jumlah Saudara Kandung</dt>
                    <dd class="text-right font-medium">{{ $siswa->jumlah_saudara }}</dd>
                </div>
                <div class="flex justify-between gap-4 py-2">
                    <dt class="text-gray-500 dark:text-gray-400">Jenis Bantuan Pendidikan</dt>
                    <dd class="text-right font-medium">{{ $siswa->bantuan_pendidikan }}</dd>
                </div>
                <div class="flex justify-between gap-4 py-2">
                    <dt class="text-gray-500 dark:text-gray-400">Ditambahkan Pada</dt>
                    <dd class="text-right font-medium">{{ $siswa->created_at->translatedFormat('d F Y H:i') }}</dd>
                </div>
                <div class="flex justify-between gap-4 py-2">
                    <dt class="text-gray-500 dark:text-gray-400">Terakhir Diperbarui</dt>
                    <dd class="text-right font-medium">{{ $siswa->updated_at->translatedFormat('d F Y H:i') }}</dd>
                </div>
            </dl>
        </div>
    </div>

    <x-slot:footer>
        <div class="flex justify-end gap-2">
            <x-button href="{{ route('admin.siswa.sekolah', $siswa->sekolah_id) }}" variant="light">Kembali</x-button>
            <x-button href="{{ route('admin.siswa.edit', $siswa) }}">Edit</x-button>
        </div>
    </x-slot:footer>
</x-card>
@endsection