@extends('layouts.admin')

@section('title', 'Tambah Sekolah')

@section('content')
    <x-breadcrumb :items="[['label' => 'Data Sekolah', 'url' => route('admin.sekolah.index')], ['label' => 'Tambah']]" />

    <form action="{{ route('admin.sekolah.store') }}" method="POST" class="flex flex-col gap-4">
        @csrf

        <x-card>
            <x-slot:header>
                <span class="font-semibold"><i class="bi bi-building me-2 text-indigo-600 dark:text-indigo-400"></i>Identitas
                    Sekolah</span>
            </x-slot:header>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <x-form.select name="user_id" label="Akun User" placeholder="Pilih user" :options="$users" :value="old('user_id')"
                    required />
                <x-form.input name="nama_sekolah" label="Nama Sekolah" :value="old('nama_sekolah')" required />
                <x-form.input name="nss" label="Nomor Statistik Sekolah" :value="old('nss')" required />
                <x-form.input name="npsn" label="Nomor Pokok Sekolah Nasional" :value="old('npsn')" required />
                <x-form.input name="nama_kepala_sekolah" label="Nama Kepala Sekolah" :value="old('nama_kepala_sekolah')" required />
                <x-form.select name="akreditasi" label="Status Akreditasi" placeholder="Pilih akreditasi" :options="['A' => 'A', 'B' => 'B', 'C' => 'C', '-' => 'Tidak Terakreditasi']"
                    :value="old('akreditasi')" required />
                <x-form.select name="status_sekolah" label="Status Kepemilikan" placeholder="Pilih status" :options="['Negeri' => 'Negeri', 'Swasta' => 'Swasta']"
                    :value="old('status_sekolah')" required />
                <x-form.input name="tanggal_sk_pendirian" label="Tanggal SK Pendirian" type="date" :value="old('tanggal_sk_pendirian')"
                    required />
                <x-form.input name="tanggal_sk_izin_oprasional" label="Tanggal SK Izin Operasional" type="date"
                    :value="old('tanggal_sk_izin_oprasional')" required />
                <x-form.input name="implementasi_kurikulum" label="Implementasi Kurikulum" :value="old('implementasi_kurikulum')" required />

                <div class="sm:col-span-2">
                    <p class="mb-2 text-sm font-medium">Dokumen SK</p>
                    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
                        <div class="flex flex-col gap-2">
                            <span class="text-sm font-medium">SK Pendirian Sekolah</span>
                            <x-button href="{{ url('https://bidangsmp.quickconnect.to/sharing/fX2sL669t') }}"
                                variant="light" size="sm" target="_blank">
                                <i class="bi bi-upload me-1 text-indigo-600 dark:text-indigo-400"></i> Upload SK Pendirian
                            </x-button>
                        </div>
                        <div class="flex flex-col gap-2">
                            <span class="text-sm font-medium">SK Izin Operasional</span>
                            <x-button href="{{ url('https://bidangsmp.quickconnect.to/sharing/9hwARFvH5') }}"
                                variant="light" size="sm" target="_blank">
                                <i class="bi bi-upload me-1 text-indigo-600 dark:text-indigo-400"></i> Upload SK Izin
                                Operasional
                            </x-button>
                        </div>
                        <div class="flex flex-col gap-2">
                            <span class="text-sm font-medium">SK Akreditasi Sekolah</span>
                            <x-button href="{{ url('https://bidangsmp.quickconnect.to/sharing/8OHlgLGeg') }}"
                                variant="light" size="sm" target="_blank">
                                <i class="bi bi-upload me-1 text-indigo-600 dark:text-indigo-400"></i> Upload SK Akreditasi
                            </x-button>
                        </div>
                    </div>
                </div>
            </div>
        </x-card>

        <x-card>
            <x-slot:header>
                <span class="font-semibold"><i class="bi bi-bullseye me-2 text-violet-600 dark:text-violet-400"></i>Visi &
                    Misi</span>
            </x-slot:header>

            <div class="grid grid-cols-1 gap-4">
                <x-form.textarea name="visi" label="Visi" rows="2">{{ old('visi') }}</x-form.textarea>
                <x-form.textarea name="misi" label="Misi (satu poin per baris)" rows="5"
                    placeholder="Contoh:&#10;Menyelenggarakan pembelajaran yang aktif&#10;Menumbuhkan karakter disiplin">{{ old('misi') }}</x-form.textarea>
            </div>
        </x-card>

        <x-card>
            <x-slot:header>
                <span class="font-semibold"><i class="bi bi-trophy me-2 text-amber-500"></i>Prestasi Sekolah</span>
            </x-slot:header>

            @php
                // Baris prestasi: dari input sebelumnya (jika validasi gagal), data tersimpan, atau satu baris kosong
                $barisPrestasi = old('nama_prestasi')
                    ? array_map(null, old('jenis_prestasi', []), old('nama_prestasi'))
                    : [[null, null]];
                $kelasInput =
                    'w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/30 dark:border-gray-600 dark:bg-gray-800';
            @endphp

            <div id="daftarPrestasi" class="flex flex-col gap-2">
                @foreach ($barisPrestasi as [$jenis, $nama])
                    <div data-prestasi
                        class="grid grid-cols-1 gap-2 rounded-lg border border-gray-200 p-2 dark:border-gray-700 sm:grid-cols-[10rem_1fr_auto] sm:border-0 sm:p-0">
                        <select name="jenis_prestasi[]" class="{{ $kelasInput }}" aria-label="Jenis prestasi">
                            <option value="Akademik" @selected($jenis !== 'Non-Akademik')>Akademik</option>
                            <option value="Non-Akademik" @selected($jenis === 'Non-Akademik')>Non-Akademik</option>
                        </select>
                        <input type="text" name="nama_prestasi[]" value="{{ $nama }}" maxlength="255"
                            placeholder="Contoh: Juara 1 Olimpiade Sains Tingkat Kota" class="{{ $kelasInput }}"
                            aria-label="Nama prestasi">
                        <button type="button" onclick="hapusPrestasi(this)" title="Hapus baris"
                            class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-gray-500 hover:bg-rose-50 hover:text-rose-600 dark:border-gray-600 dark:bg-gray-800 dark:hover:bg-rose-500/10 sm:w-auto">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                @endforeach
            </div>

            <x-button type="button" variant="light" size="sm" class="mt-3" onclick="tambahPrestasi()">
                <i class="bi bi-plus-lg me-1"></i> Tambah Prestasi
            </x-button>
        </x-card>

        <x-card>
            <x-slot:header>
                <span class="font-semibold"><i
                        class="bi bi-geo-alt me-2 text-emerald-600 dark:text-emerald-400"></i>Alamat</span>
            </x-slot:header>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div class="md:col-span-2">
                    <x-form.textarea name="alamat" label="Alamat Sekolah" rows="2"
                        required>{{ old('alamat') }}</x-form.textarea>
                </div>
                <x-form.input name="rt_rw" label="RT/RW" :value="old('rt_rw')" required />
                <x-form.input name="desa_kelurahan" label="Desa/Kelurahan" :value="old('desa_kelurahan')" required />
                <x-form.input name="kecamatan" label="Kecamatan" :value="old('kecamatan')" required />
                <x-form.input name="kabupaten" label="Kabupaten" :value="old('kabupaten')" required />
                <x-form.input name="provinsi" label="Provinsi" :value="old('provinsi')" required />
                <x-form.input name="kode_pos" label="Kode Pos" :value="old('kode_pos')" required />


            </div>
        </x-card>

        <x-card>
            <x-slot:header>
                <span class="font-semibold"><i class="bi bi-lightning-charge me-2 text-amber-500"></i>Sarana
                    Pendukung</span>
            </x-slot:header>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <x-form.input name="laus_tanah" label="Luas Tanah" type="number" :value="old('laus_tanah')" required>
                    <x-slot:suffix>m²</x-slot:suffix>
                </x-form.input>
                <x-form.input name="laus_bangunan" label="Luas Bangunan" type="number" :value="old('laus_bangunan')" required>
                    <x-slot:suffix>m²</x-slot:suffix>
                </x-form.input>
                <x-form.input name="tipe_internet" label="Tipe Internet" placeholder="Contoh: Fiber Optik"
                    :value="old('tipe_internet')" />
                <x-form.input name="internet_provider" label="Provider Internet" placeholder="Contoh: IndiHome"
                    :value="old('internet_provider')" />
                <x-form.input name="bandwith_internet" label="Bandwidth Internet" type="number" :value="old('bandwith_internet')">
                    <x-slot:suffix>Mbps</x-slot:suffix>
                </x-form.input>
                <x-form.input name="sumber_listrik" label="Sumber Listrik" :value="old('sumber_listrik')" />
                <x-form.input name="daya_listrik" label="Daya Listrik" type="number" :value="old('daya_listrik')">
                    <x-slot:suffix>VA</x-slot:suffix>
                </x-form.input>
                <x-form.input name="sumber_air" label="Sumber Air" :value="old('sumber_air')" />

            </div>
        </x-card>

        <div class="flex flex-col-reverse gap-2 sm:flex-row sm:justify-end">
            <x-button href="{{ route('admin.sekolah.index') }}" variant="light"
                class="w-full sm:w-auto">Batal</x-button>
            <x-button type="submit" class="w-full sm:w-auto">
                <i class="bi bi-check-lg me-1"></i> Simpan
            </x-button>
        </div>
    </form>

    <script>
        function tambahPrestasi() {
            const wadah = document.getElementById('daftarPrestasi');
            const baris = wadah.firstElementChild.cloneNode(true);
            baris.querySelector('input').value = '';
            wadah.appendChild(baris);
            baris.querySelector('input').focus();
        }

        function hapusPrestasi(tombol) {
            const wadah = document.getElementById('daftarPrestasi');
            if (wadah.children.length > 1) tombol.closest('[data-prestasi]').remove();
            else tombol.closest('[data-prestasi]').querySelector('input').value = '';
        }
    </script>
@endsection
