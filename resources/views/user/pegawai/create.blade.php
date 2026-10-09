@extends('layouts.user')

@section('title', 'Tambah Pegawai')

@section('content')
    @php $manual = old('nama') !== null; @endphp
    <x-card>
        <x-slot:header>
            <span class="font-semibold">Tambah Pegawai</span>
        </x-slot:header>

        <x-tabs id="tambahPegawaiTabs">
            <x-slot:nav>
                <x-tabs.link target="tab-excel" :active="!$manual">
                    <i class="bi bi-file-earmark-excel me-1"></i> Upload Excel
                </x-tabs.link>
                <x-tabs.link target="tab-manual" :active="$manual">
                    <i class="bi bi-pencil-square me-1"></i> Isi Manual
                </x-tabs.link>
            </x-slot:nav>

            {{-- ===== Upload Excel ===== --}}
            <x-tabs.pane id="tab-excel" :active="!$manual">
                <form action="{{ route('user.pegawai.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <x-form.input name="file" label="File Excel" type="file" accept=".xlsx,.xls"
                        helper="Format .xlsx atau .xls, maksimal 5 MB." required />

                    <div class="mt-4 rounded border border-gray-200 p-4 text-sm dark:border-gray-700">
                        <p class="mb-2 font-semibold">Petunjuk</p>
                        <ol class="list-decimal space-y-1 ps-5 text-gray-600 dark:text-gray-300">
                            <li>Download template, lalu isi data pegawai pada sheet "Data Pegawai" mulai <strong>baris
                                    ke-2</strong>. Baris contoh di template harus dihapus atau diganti, karena ikut
                                tersimpan kalau dibiarkan.</li>
                            <li>Pegawai yang diimport otomatis masuk ke sekolah Anda.</li>
                            <li>Kolom Tempat, Tanggal Lahir ditulis <strong>Tempat, tanggal</strong>, contoh: <em>Lahat, 12
                                    Mei 1985</em> atau <em>Lahat, 12-05-1985</em>.</li>
                            <li>Kolom TMT di Sekolah Ini diisi tanggal, dan kolom berdropdown harus memakai pilihan yang
                                tersedia.</li>
                            <li>Jika ada baris yang salah, tidak ada data yang tersimpan dan baris bermasalah akan
                                ditampilkan.</li>
                        </ol>
                    </div>

                    <div class="mt-6 flex flex-wrap justify-between gap-2">
                        <x-button href="{{ route('user.pegawai.download') }}" variant="light">
                            <i class="bi bi-download me-1"></i> Download Template
                        </x-button>
                        <div class="flex gap-2">
                            <x-button href="{{ route('user.pegawai.index') }}" variant="light">Batal</x-button>
                            <x-button type="submit">
                                <i class="bi bi-upload me-1"></i> Import
                            </x-button>
                        </div>
                    </div>
                </form>
            </x-tabs.pane>

            {{-- ===== Isi Manual ===== --}}
            <x-tabs.pane id="tab-manual" :active="$manual">
                <form action="{{ route('user.pegawai.store') }}" method="POST">
                    @csrf

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <h3 class="font-semibold md:col-span-2">Data Pribadi</h3>

                        <x-form.input name="nama" label="Nama Lengkap Beserta Gelar" :value="old('nama')" required />
                        <x-form.input name="nik" label="NIK" :value="old('nik')" required />
                        <x-form.input name="nip" label="NIP/NIPPPK/NIPPPKPW" helper="Kosongkan jika tidak ada."
                            :value="old('nip')" />
                        <x-form.select name="jenis_kelamin" label="Jenis Kelamin" placeholder="Pilih jenis kelamin"
                            :options="$opsi['jenis_kelamin']" :value="old('jenis_kelamin')" required />
                        <x-form.select name="agama" label="Agama" placeholder="Pilih agama" :options="$opsi['agama']"
                            :value="old('agama')" required />
                        <x-form.input name="tempat_lahir" label="Tempat Lahir" :value="old('tempat_lahir')" required />
                        <x-form.input name="tanggal_lahir" label="Tanggal Lahir" type="date" :value="old('tanggal_lahir')"
                            required />
                        <div class="md:col-span-2">
                            <x-form.textarea name="alamat" label="Alamat Tempat Tinggal" rows="2"
                                required>{{ old('alamat') }}</x-form.textarea>
                        </div>

                        <h3 class="mt-2 font-semibold md:col-span-2">Kepegawaian</h3>

                        <x-form.input name="golongan" label="Golongan" helper="Contoh: III/a. Kosongkan jika tidak ada."
                            :value="old('golongan')" />
                        <x-form.input name="pangkat" label="Pangkat" helper="Kosongkan jika tidak ada."
                            :value="old('pangkat')" />
                        <x-form.input name="terhitung_mulai_tanggal" label="TMT di Sekolah Ini" type="date"
                            :value="old('terhitung_mulai_tanggal')" required />
                        <x-form.select name="jabatan" label="Jabatan" placeholder="Pilih jabatan" :options="$opsi['jabatan']"
                            :value="old('jabatan')" required />
                        <x-form.select name="tugas" label="Tugas" placeholder="Pilih tugas" :options="$opsi['tugas']"
                            :value="old('tugas')" required />
                        <x-form.select name="status_kepegawaian" label="Status Kepegawaian" placeholder="Pilih status"
                            :options="$opsi['status_kepegawaian']" :value="old('status_kepegawaian')" required />

                        <h3 class="mt-2 font-semibold md:col-span-2">Pendidikan</h3>

                        <x-form.select name="pendidikan_terakhir" label="Pendidikan Terakhir" placeholder="Pilih pendidikan"
                            :options="$opsi['pendidikan']" :value="old('pendidikan_terakhir')" required />
                        <x-form.input name="unit_satuan_pendidikan_terakhir" label="Unit Satuan Pendidikan Terakhir"
                            helper="Nama sekolah/kampus pendidikan terakhir." :value="old('unit_satuan_pendidikan_terakhir')" required />
                    </div>

                    <div class="mt-6 flex justify-end gap-2">
                        <x-button href="{{ route('user.pegawai.index') }}" variant="light">Batal</x-button>
                        <x-button type="submit">Simpan</x-button>
                    </div>
                </form>
            </x-tabs.pane>
        </x-tabs>
    </x-card>
@endsection
