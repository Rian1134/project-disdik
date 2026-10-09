@extends('layouts.user')

@section('title', 'Edit Siswa')

@section('content')
<x-card>
    <x-slot:header>
        <span class="font-semibold">Edit Siswa</span>
    </x-slot:header>

    <form action="{{ route('user.siswa.update', $siswa) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            <h3 class="font-semibold md:col-span-2">Data Siswa</h3>

            <x-form.input name="nama_siswa" label="Nama Siswa" :value="old('nama_siswa', $siswa->nama_siswa)" required />
            <x-form.input name="nik" label="NIK" :value="old('nik', $siswa->nik)" required />
            <x-form.input name="nisn" label="NISN" :value="old('nisn', $siswa->nisn)" required />
            <x-form.input name="kelas" label="Kelas" helper="Contoh: 7 A" :value="old('kelas', $siswa->kelas)" required />
            <x-form.select name="jenis_kelamin" label="Jenis Kelamin" placeholder="Pilih jenis kelamin" :options="$opsi['jenis_kelamin']" :value="old('jenis_kelamin', $siswa->jenis_kelamin)" required />
            <x-form.input name="tempat_lahir" label="Tempat Lahir" :value="old('tempat_lahir', $siswa->tempat_lahir)" required />
            <x-form.input name="tanggal_lahir" label="Tanggal Lahir" type="date" :value="old('tanggal_lahir', $siswa->tanggal_lahir?->format('Y-m-d'))" required />
            <div class="md:col-span-2">
                <x-form.textarea name="alamat" label="Alamat Tempat Tinggal" rows="2" required>{{ old('alamat', $siswa->alamat) }}</x-form.textarea>
            </div>
            <x-form.select name="status_tempat_tinggal" label="Status Tempat Tinggal" placeholder="Pilih status" :options="$opsi['status_tempat_tinggal']" :value="old('status_tempat_tinggal', $siswa->status_tempat_tinggal)" required />
            <x-form.select name="status_pelajar" label="Status Pelajar di Sekolah" placeholder="Pilih status" :options="$opsi['status_pelajar']" :value="old('status_pelajar', $siswa->status_pelajar)" required />

            <h3 class="mt-2 font-semibold md:col-span-2">Orang Tua</h3>

            <x-form.input name="nama_ayah" label="Nama Ayah" :value="old('nama_ayah', $siswa->nama_ayah)" required />
            <x-form.input name="nama_ibu" label="Nama Ibu" :value="old('nama_ibu', $siswa->nama_ibu)" required />
            <x-form.select name="pekerjaan_ayah" label="Pekerjaan Ayah" placeholder="Pilih pekerjaan" :options="$opsi['pekerjaan']" :value="old('pekerjaan_ayah', $siswa->pekerjaan_ayah)" required />
            <x-form.select name="pekerjaan_ibu" label="Pekerjaan Ibu" placeholder="Pilih pekerjaan" :options="$opsi['pekerjaan']" :value="old('pekerjaan_ibu', $siswa->pekerjaan_ibu)" required />
            <x-form.select name="kisaran_penghasilan_ayah" label="Kisaran Penghasilan Ayah" placeholder="Pilih penghasilan" :options="$opsi['penghasilan']" :value="old('kisaran_penghasilan_ayah', $siswa->kisaran_penghasilan_ayah)" required />
            <x-form.select name="kisaran_penghasilan_ibu" label="Kisaran Penghasilan Ibu" placeholder="Pilih penghasilan" :options="$opsi['penghasilan']" :value="old('kisaran_penghasilan_ibu', $siswa->kisaran_penghasilan_ibu)" required />

            <h3 class="mt-2 font-semibold md:col-span-2">Lainnya</h3>

            <x-form.input name="jumlah_saudara" label="Jumlah Saudara Kandung" type="number" :value="old('jumlah_saudara', $siswa->jumlah_saudara)" required />
            <x-form.select name="bantuan_pendidikan" label="Jenis Bantuan Pendidikan" placeholder="Pilih bantuan" :options="$opsi['bantuan']" :value="old('bantuan_pendidikan', $siswa->bantuan_pendidikan)" required />
        </div>

        <div class="mt-6 flex justify-end gap-2">
            <x-button href="{{ route('user.siswa.index') }}" variant="light">Batal</x-button>
            <x-button type="submit">Simpan</x-button>
        </div>
    </form>
</x-card>
@endsection