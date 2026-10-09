@extends('layouts.admin')

@section('title', 'Tambah Siswa')

@section('content')
    @php $manual = old('nama_siswa') !== null; @endphp
    <x-card>
        <x-slot:header>
            <span class="font-semibold"><i class="bi bi-person-plus-fill me-2 text-emerald-500"></i>Tambah Siswa</span>
        </x-slot:header>

        <x-tabs id="tambahSiswaTabs">
            <x-slot:nav>
                <x-tabs.link target="tab-excel" :active="!$manual">
                    <i class="bi bi-file-earmark-excel me-1 text-emerald-600 dark:text-emerald-400"></i> Upload Excel
                </x-tabs.link>
                <x-tabs.link target="tab-manual" :active="$manual">
                    <i class="bi bi-pencil-square me-1 text-amber-500"></i> Isi Manual
                </x-tabs.link>
            </x-slot:nav>

            {{-- ===== Upload Excel ===== --}}
            <x-tabs.pane id="tab-excel" :active="!$manual">
                <form action="{{ route('admin.siswa.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <x-form.select name="sekolah_id" label="Sekolah" placeholder="Pilih sekolah" :options="$sekolahs"
                            :value="old('sekolah_id', request('sekolah_id'))" required />
                        <x-form.input name="file" label="File Excel" type="file" accept=".xlsx,.xls"
                            helper="Format .xlsx atau .xls, maksimal 5 MB." required />
                    </div>

                    <div
                        class="mt-4 rounded-lg border border-sky-200 bg-sky-50 p-4 text-sm dark:border-sky-500/30 dark:bg-sky-500/10">
                        <p class="mb-2 font-semibold text-sky-700 dark:text-sky-300"><i
                                class="bi bi-info-circle-fill me-1"></i>Petunjuk</p>
                        <ol class="list-decimal space-y-1 ps-5 text-gray-600 dark:text-gray-300">
                            <li>Download template, lalu isi data siswa pada sheet "Data Siswa" mulai baris ke-3.</li>
                            <li>Kolom Tempat Tanggal Lahir ditulis <strong>Tempat, tanggal</strong>, contoh: <em>Lahat, 12
                                    Mei 2010</em> atau <em>Lahat, 12-05-2010</em>.</li>
                            <li>Kolom berdropdown (jenis kelamin, pekerjaan, penghasilan, dll.) harus memakai pilihan yang
                                tersedia.</li>
                            <li>Jika ada baris yang salah, tidak ada data yang tersimpan dan baris bermasalah akan
                                ditampilkan.</li>
                        </ol>
                    </div>

                    <div class="mt-6 flex flex-wrap justify-between gap-2">
                        <x-button href="{{ route('admin.files.download.siswa') }}" variant="light">
                            <i class="bi bi-download me-1 text-emerald-600 dark:text-emerald-400"></i> Download Template
                        </x-button>
                        <div class="flex gap-2">
                            <x-button href="{{ route('admin.siswa.index') }}" variant="light">Batal</x-button>
                            <x-button type="submit">
                                <i class="bi bi-upload me-1"></i> Import
                            </x-button>
                        </div>
                    </div>
                </form>
            </x-tabs.pane>

            {{-- ===== Isi Manual ===== --}}
            <x-tabs.pane id="tab-manual" :active="$manual">
                <form action="{{ route('admin.siswa.store') }}" method="POST">
                    @csrf

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <h3
                            class="flex items-center gap-2 font-semibold text-indigo-700 dark:text-indigo-300 md:col-span-2">
                            <i class="bi bi-person-vcard-fill"></i>Data Siswa</h3>

                        <x-form.select name="sekolah_id" label="Sekolah" placeholder="Pilih sekolah" :options="$sekolahs"
                            :value="old('sekolah_id', request('sekolah_id'))" required />
                        <x-form.input name="nama_siswa" label="Nama Siswa" :value="old('nama_siswa')" required />
                        <x-form.input name="nik" label="NIK" :value="old('nik')" required />
                        <x-form.input name="nisn" label="NISN" :value="old('nisn')" required />
                        <x-form.input name="kelas" label="Kelas" helper="Contoh: VII A" :value="old('kelas')" required />
                        <x-form.select name="jenis_kelamin" label="Jenis Kelamin" placeholder="Pilih jenis kelamin"
                            :options="$opsi['jenis_kelamin']" :value="old('jenis_kelamin')" required />
                        <x-form.input name="tempat_lahir" label="Tempat Lahir" :value="old('tempat_lahir')" required />
                        <x-form.input name="tanggal_lahir" label="Tanggal Lahir" type="date" :value="old('tanggal_lahir')"
                            required />
                        <div class="md:col-span-2">
                            <x-form.textarea name="alamat" label="Alamat Tempat Tinggal" rows="2"
                                required>{{ old('alamat') }}</x-form.textarea>
                        </div>
                        <x-form.select name="status_tempat_tinggal" label="Status Tempat Tinggal" placeholder="Pilih status"
                            :options="$opsi['status_tempat_tinggal']" :value="old('status_tempat_tinggal')" required />
                        <x-form.select name="status_pelajar" label="Status Pelajar di Sekolah" placeholder="Pilih status"
                            :options="$opsi['status_pelajar']" :value="old('status_pelajar')" required />

                        <h3
                            class="mt-2 flex items-center gap-2 font-semibold text-amber-600 dark:text-amber-300 md:col-span-2">
                            <i class="bi bi-people-fill"></i>Orang Tua</h3>

                        <x-form.input name="nama_ayah" label="Nama Ayah" :value="old('nama_ayah')" required />
                        <x-form.input name="nama_ibu" label="Nama Ibu" :value="old('nama_ibu')" required />
                        <x-form.select name="pekerjaan_ayah" label="Pekerjaan Ayah" placeholder="Pilih pekerjaan"
                            :options="$opsi['pekerjaan']" :value="old('pekerjaan_ayah')" required />
                        <x-form.select name="pekerjaan_ibu" label="Pekerjaan Ibu" placeholder="Pilih pekerjaan"
                            :options="$opsi['pekerjaan']" :value="old('pekerjaan_ibu')" required />
                        <x-form.select name="kisaran_penghasilan_ayah" label="Kisaran Penghasilan Ayah"
                            placeholder="Pilih penghasilan" :options="$opsi['penghasilan']" :value="old('kisaran_penghasilan_ayah')" required />
                        <x-form.select name="kisaran_penghasilan_ibu" label="Kisaran Penghasilan Ibu"
                            placeholder="Pilih penghasilan" :options="$opsi['penghasilan']" :value="old('kisaran_penghasilan_ibu')" required />

                        <h3
                            class="mt-2 flex items-center gap-2 font-semibold text-emerald-600 dark:text-emerald-300 md:col-span-2">
                            <i class="bi bi-info-circle-fill"></i>Lainnya</h3>

                        <x-form.input name="jumlah_saudara" label="Jumlah Saudara Kandung" type="number" :value="old('jumlah_saudara')"
                            required />
                        <x-form.select name="bantuan_pendidikan" label="Jenis Bantuan Pendidikan"
                            placeholder="Pilih bantuan" :options="$opsi['bantuan']" :value="old('bantuan_pendidikan')" required />
                    </div>

                    <div class="mt-6 flex justify-end gap-2">
                        <x-button href="{{ route('admin.siswa.index') }}" variant="light">Batal</x-button>
                        <x-button type="submit">Simpan</x-button>
                    </div>
                </form>
            </x-tabs.pane>
        </x-tabs>
    </x-card>
@endsection
