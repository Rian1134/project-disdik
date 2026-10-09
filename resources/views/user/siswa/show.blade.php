@extends('layouts.user')

@section('title', 'Detail Siswa')

@section('content')
    <div class="mx-auto max-w-3xl">
        <div class="mb-4 flex flex-wrap items-center justify-between gap-2">
            <div>
                <h1 class="text-xl font-semibold text-gray-800">Detail Siswa</h1>
                <p class="text-sm text-gray-500">{{ $siswa->nama_siswa }}</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('user.siswa.index') }}"
                   class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-700 hover:bg-gray-50">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
                <a href="{{ route('user.siswa.edit', $siswa) }}"
                   class="inline-flex items-center gap-2 rounded-lg bg-amber-500 px-3 py-2 text-sm font-medium text-white hover:bg-amber-600">
                    <i class="bi bi-pencil-square"></i> Edit
                </a>
           @extends('layouts.user')

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
                    <dd class="text-right font-medium">{{ $siswa->tanggal_lahir?->translatedFormat('d F Y') }}</dd>
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
                    <dd class="text-right font-medium">{{ $siswa->created_at?->translatedFormat('d F Y H:i') }}</dd>
                </div>
                <div class="flex justify-between gap-4 py-2">
                    <dt class="text-gray-500 dark:text-gray-400">Terakhir Diperbarui</dt>
                    <dd class="text-right font-medium">{{ $siswa->updated_at?->translatedFormat('d F Y H:i') }}</dd>
                </div>
            </dl>
        </div>
    </div>

    <x-slot:footer>
        <div class="flex justify-end gap-2">
            <x-button href="{{ route('user.siswa.index') }}" variant="light">Kembali</x-button>
            <x-button href="{{ route('user.siswa.edit', $siswa) }}">Edit</x-button>
        </div>
    </x-slot:footer>
</x-card>
@endsection </div>
        </div>

        <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm sm:p-6">
            <dl class="grid grid-cols-1 gap-x-6 gap-y-4 sm:grid-cols-2">
                @foreach ($fields as $key => $label)
                    @php
                        $nilai = $siswa->{$key};
                        if ($key === 'jenis_kelamin') {
                            $nilai = $opsi['jenis_kelamin'][$nilai] ?? $nilai;
                        }
                        if ($nilai instanceof \Carbon\CarbonInterface) {
                            $nilai = $nilai->format('d-m-Y');
                        }
                    @endphp
                    <div>
                        <dt class="text-xs font-medium uppercase tracking-wide text-gray-500">{{ $label }}</dt>
                        <dd class="mt-1 text-sm text-gray-800">{{ filled($nilai) ? $nilai : '-' }}</dd>
                    </div>
                @endforeach
            </dl>
        </div>
    </div>
@endsection