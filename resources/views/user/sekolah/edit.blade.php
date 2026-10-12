@extends('layouts.user')

@section('title', 'Edit Data Sekolah')

@section('content')
    @php
        // Tanggal dari model bisa berupa string atau Carbon; <input type="date"> butuh format Y-m-d.
        $tglInput = fn($nilai) => $nilai ? \Illuminate\Support\Carbon::parse($nilai)->format('Y-m-d') : null;

        $judulSeksi = 'mb-4 flex items-center gap-2 font-semibold';
        $ikonSeksi =
            'inline-flex h-7 w-7 items-center justify-center rounded-md bg-emerald-50 text-emerald-600 dark:bg-emerald-500/15 dark:text-emerald-300';
        $kotakSeksi = 'rounded-lg border border-gray-200 p-4 dark:border-gray-700';
        $kotakUnggah = 'flex flex-col gap-2 rounded-lg border border-dashed border-gray-300 p-3 dark:border-gray-600';
    @endphp

    <x-card>
        <x-slot:header>
            <span class="font-semibold">
                <i class="bi bi-pencil-square me-1 text-emerald-600 dark:text-emerald-400"></i> Edit Data Sekolah
            </span>
        </x-slot:header>

        <form action="{{ route('user.sekolah.update', $sekolah) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="flex flex-col gap-5">

                {{-- ===== Identitas Sekolah ===== --}}
                <section class="{{ $kotakSeksi }}">
                    <h3 class="{{ $judulSeksi }}">
                        <span class="{{ $ikonSeksi }}"><i class="bi bi-card-text"></i></span> Identitas Sekolah
                    </h3>

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <x-form.input name="nama_sekolah" label="Nama Sekolah" :value="old('nama_sekolah', $sekolah->nama_sekolah)" required />
                        <x-form.input name="nss" label="Nomor Statistik Sekolah" :value="old('nss', $sekolah->nss)" required />
                        <x-form.input name="npsn" label="Nomor Pokok Sekolah Nasional" :value="old('npsn', $sekolah->npsn)" required />
                        <x-form.input name="nama_kepala_sekolah" label="Nama Kepala Sekolah" :value="old('nama_kepala_sekolah', $sekolah->nama_kepala_sekolah)" required />
                        <x-form.select name="akreditasi" label="Status Akreditasi" placeholder="Pilih akreditasi"
                            :options="['A' => 'A', 'B' => 'B', 'C' => 'C', '-' => 'Tidak Terakreditasi']" :value="old('akreditasi', $sekolah->akreditasi)" required />
                        <x-form.select name="status_sekolah" label="Status Kepemilikan" placeholder="Pilih status"
                            :options="['Negeri' => 'Negeri', 'Swasta' => 'Swasta']" :value="old('status_sekolah', $sekolah->status_sekolah)" required />
                        <x-form.input name="tanggal_sk_pendirian" label="Tanggal SK Pendirian" type="date"
                            :value="old('tanggal_sk_pendirian', $tglInput($sekolah->tanggal_sk_pendirian))" required />
                        <x-form.input name="tanggal_sk_izin_oprasional" label="Tanggal SK Izin Operasional" type="date"
                            :value="old(
                                'tanggal_sk_izin_oprasional',
                                $tglInput($sekolah->tanggal_sk_izin_oprasional),
                            )" required />
                        <div class="md:col-span-2">
                            <x-form.input name="implementasi_kurikulum" label="Implementasi Kurikulum" :value="old('implementasi_kurikulum', $sekolah->implementasi_kurikulum)"
                                required />
                        </div>
                    </div>
                </section>

                {{-- ===== Dokumen SK ===== --}}
                <section class="{{ $kotakSeksi }}">
                    <h3 class="{{ $judulSeksi }}">
                        <span class="{{ $ikonSeksi }}"><i class="bi bi-file-earmark-text"></i></span> Dokumen SK
                    </h3>

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                        <div class="{{ $kotakUnggah }}">
                            <span class="text-sm font-medium">SK Pendirian Sekolah</span>
                            <x-button href="#" variant="light" size="sm" target="_blank">
                                <i class="bi bi-upload me-1"></i> Upload SK Pendirian
                            </x-button>
                        </div>
                        <div class="{{ $kotakUnggah }}">
                            <span class="text-sm font-medium">SK Izin Operasional</span>
                            <x-button href="#" variant="light" size="sm" target="_blank">
                                <i class="bi bi-upload me-1"></i> Upload SK Izin Operasional
                            </x-button>
                        </div>
                        <div class="{{ $kotakUnggah }}">
                            <span class="text-sm font-medium">SK Akreditasi Sekolah</span>
                            <x-button href="#" variant="light" size="sm" target="_blank">
                                <i class="bi bi-upload me-1"></i> Upload SK Akreditasi
                            </x-button>
                        </div>
                    </div>
                </section>

                {{-- ===== Alamat ===== --}}
                <section class="{{ $kotakSeksi }}">
                    <h3 class="{{ $judulSeksi }}">
                        <span class="{{ $ikonSeksi }}"><i class="bi bi-geo-alt"></i></span> Alamat
                    </h3>

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <div class="md:col-span-2">
                            <x-form.textarea name="alamat" label="Alamat Sekolah" rows="2"
                                required>{{ old('alamat', $sekolah->alamat) }}</x-form.textarea>
                        </div>
                        <x-form.input name="rt_rw" label="RT/RW" :value="old('rt_rw', $sekolah->rt_rw)" required />
                        <x-form.input name="desa_kelurahan" label="Desa/Kelurahan" :value="old('desa_kelurahan', $sekolah->desa_kelurahan)" required />
                        <x-form.input name="kecamatan" label="Kecamatan" :value="old('kecamatan', $sekolah->kecamatan)" required />
                        <x-form.input name="kabupaten" label="Kabupaten" :value="old('kabupaten', $sekolah->kabupaten)" required />
                        <x-form.input name="provinsi" label="Provinsi" :value="old('provinsi', $sekolah->provinsi)" required />
                        <x-form.input name="kode_pos" label="Kode Pos" :value="old('kode_pos', $sekolah->kode_pos)" required />
                    </div>
                </section>

                {{-- ===== Sarana Pendukung ===== --}}
                <section class="{{ $kotakSeksi }}">
                    <h3 class="{{ $judulSeksi }}">
                        <span class="{{ $ikonSeksi }}"><i class="bi bi-lightning-charge"></i></span> Sarana Pendukung
                    </h3>

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <x-form.input name="laus_tanah" label="Luas Tanah" type="number" :value="old('laus_tanah', $sekolah->laus_tanah)" required>
                            <x-slot:suffix>m²</x-slot:suffix>
                        </x-form.input>
                        <x-form.input name="laus_bangunan" label="Luas Bangunan" type="number" :value="old('laus_bangunan', $sekolah->laus_bangunan)" required>
                            <x-slot:suffix>m²</x-slot:suffix>
                        </x-form.input>
                        <x-form.input name="tipe_internet" label="Tipe Internet" placeholder="Contoh: Fiber Optik"
                            :value="old('tipe_internet', $sekolah->tipe_internet)" />
                        <x-form.input name="internet_provider" label="Provider Internet" placeholder="Contoh: IndiHome"
                            :value="old('internet_provider', $sekolah->internet_provider)" />
                        <x-form.input name="bandwith_internet" label="Bandwidth Internet" type="number" :value="old('bandwith_internet', $sekolah->bandwith_internet)">
                            <x-slot:suffix>Mbps</x-slot:suffix>
                        </x-form.input>
                        <x-form.input name="sumber_listrik" label="Sumber Listrik" :value="old('sumber_listrik', $sekolah->sumber_listrik)" />
                        <x-form.input name="daya_listrik" label="Daya Listrik" type="number" :value="old('daya_listrik', $sekolah->daya_listrik)">
                            <x-slot:suffix>VA</x-slot:suffix>
                        </x-form.input>
                        <x-form.input name="sumber_air" label="Sumber Air" :value="old('sumber_air', $sekolah->sumber_air)" />
                    </div>
                </section>
            </div>

            <div class="mt-6 flex justify-end gap-2 border-t border-gray-100 pt-4 dark:border-gray-800">
                <x-button href="{{ route('user.sekolah.index') }}" variant="light">Batal</x-button>
                <x-button type="submit">
                    <i class="bi bi-check-lg me-1"></i> Simpan
                </x-button>
            </div>
        </form>
    </x-card>
@endsection
