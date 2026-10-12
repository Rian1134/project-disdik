@extends('layouts.user')

@section('title', 'Edit Pegawai')

@section('content')
    @php
        $bagian =
            'flex items-center gap-2 border-b border-gray-200 pb-2 font-semibold md:col-span-2 dark:border-gray-700';
        $ikonBagian = 'text-emerald-600 dark:text-emerald-400';
    @endphp
    <x-card>
        <x-slot:header>
            <div class="flex items-center gap-3">
                <span
                    class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-emerald-600 text-base font-semibold text-white">
                    {{ mb_strtoupper(mb_substr($pegawai->nama, 0, 1)) }}
                </span>
                <div class="min-w-0">
                    <h2 class="font-semibold leading-tight">Edit Pegawai</h2>
                    <p class="truncate text-xs text-gray-500 dark:text-gray-400">
                        {{ $pegawai->nama }} &middot; {{ $pegawai->jabatan }}
                    </p>
                </div>
            </div>
        </x-slot:header>

        <form action="{{ route('user.pegawai.update', $pegawai) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <h3 class="{{ $bagian }}"><i class="bi bi-person-vcard {{ $ikonBagian }}"></i> Data Pribadi</h3>

                <x-form.input name="nama" label="Nama Lengkap Beserta Gelar" :value="old('nama', $pegawai->nama)" required />
                <x-form.input name="nik" label="NIK" :value="old('nik', $pegawai->nik)" required />
                <x-form.input name="nip" label="NIP/NIPPPK/NIPPPKPW" helper="Kosongkan jika tidak ada."
                    :value="old('nip', $pegawai->nip)" />
                <x-form.select name="jenis_kelamin" label="Jenis Kelamin" placeholder="Pilih jenis kelamin"
                    :options="$opsi['jenis_kelamin']" :value="old('jenis_kelamin', $pegawai->jenis_kelamin)" required />
                <x-form.select name="agama" label="Agama" placeholder="Pilih agama" :options="$opsi['agama']" :value="old('agama', $pegawai->agama)"
                    required />
                <x-form.input name="tempat_lahir" label="Tempat Lahir" :value="old('tempat_lahir', $pegawai->tempat_lahir)" required />
                <x-form.input name="tanggal_lahir" label="Tanggal Lahir" type="date" :value="old('tanggal_lahir', $pegawai->tanggal_lahir?->format('Y-m-d'))" required />
                <div class="md:col-span-2">
                    <x-form.textarea name="alamat" label="Alamat Tempat Tinggal" rows="2"
                        required>{{ old('alamat', $pegawai->alamat) }}</x-form.textarea>
                </div>

                <h3 class="{{ $bagian }} mt-2"><i class="bi bi-briefcase {{ $ikonBagian }}"></i> Kepegawaian</h3>

                <x-form.input name="golongan" label="Golongan" helper="Contoh: III/a. Kosongkan jika tidak ada."
                    :value="old('golongan', $pegawai->golongan)" />
                <x-form.input name="pangkat" label="Pangkat" helper="Kosongkan jika tidak ada." :value="old('pangkat', $pegawai->pangkat)" />
                <x-form.input name="terhitung_mulai_tanggal" label="TMT di Sekolah Ini" type="date" :value="old('terhitung_mulai_tanggal', $pegawai->terhitung_mulai_tanggal?->format('Y-m-d'))"
                    required />
                <x-form.select name="jabatan" label="Jabatan" placeholder="Pilih jabatan" :options="$opsi['jabatan']"
                    :value="old('jabatan', $pegawai->jabatan)" required />
                <x-form.select name="tugas" label="Tugas" placeholder="Pilih tugas" :options="$opsi['tugas']" :value="old('tugas', $pegawai->tugas)"
                    required />
                <x-form.select name="status_kepegawaian" label="Status Kepegawaian" placeholder="Pilih status"
                    :options="$opsi['status_kepegawaian']" :value="old('status_kepegawaian', $pegawai->status_kepegawaian)" required />

                <h3 class="{{ $bagian }} mt-2"><i class="bi bi-mortarboard {{ $ikonBagian }}"></i> Pendidikan</h3>

                <x-form.select name="pendidikan_terakhir" label="Pendidikan Terakhir" placeholder="Pilih pendidikan"
                    :options="$opsi['pendidikan']" :value="old('pendidikan_terakhir', $pegawai->pendidikan_terakhir)" required />
                <x-form.input name="unit_satuan_pendidikan_terakhir" label="Unit Satuan Pendidikan Terakhir"
                    helper="Nama sekolah/kampus pendidikan terakhir." :value="old('unit_satuan_pendidikan_terakhir', $pegawai->unit_satuan_pendidikan_terakhir)" required />
            </div>

            <div class="mt-6 flex justify-end gap-2 border-t border-gray-200 pt-4 dark:border-gray-700">
                <x-button href="{{ route('user.pegawai.index') }}" variant="light">Batal</x-button>
                <x-button type="submit"><i class="bi bi-check-lg me-1"></i> Simpan</x-button>
            </div>
        </form>
    </x-card>
@endsection
