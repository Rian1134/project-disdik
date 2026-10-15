@extends('layouts.admin')

@section('title', 'Detail Sekolah')

@section('content')
    @php
        $tgl = fn($nilai) => $nilai ? \Illuminate\Support\Carbon::parse($nilai)->translatedFormat('d F Y') : '-';
        $isi = fn($nilai, $satuan = '') => filled($nilai) ? $nilai . $satuan : '-';

        // Misi diisi satu poin per baris
        $daftarMisi = array_filter(array_map('trim', explode("\n", (string) $sekolah->misi)));

        $identitas = [
            ['Nama Sekolah', $sekolah->nama_sekolah],
            ['Nomor Statistik Sekolah', $sekolah->nss],
            ['Nomor Pokok Sekolah Nasional', $sekolah->npsn],
            ['Nama Kepala Sekolah', $sekolah->nama_kepala_sekolah],
            ['Status Akreditasi', $sekolah->akreditasi === '-' ? 'Tidak Terakreditasi' : $sekolah->akreditasi],
            ['Status Kepemilikan', $sekolah->status_sekolah],
            ['Tanggal SK Pendirian', $tgl($sekolah->tanggal_sk_pendirian)],
            ['Tanggal SK Izin Operasional', $tgl($sekolah->tanggal_sk_izin_oprasional)],
            ['Implementasi Kurikulum', $sekolah->implementasi_kurikulum],
        ];

        $alamat = [
            ['Alamat', $sekolah->alamat],
            ['RT/RW', $sekolah->rt_rw],
            ['Desa/Kelurahan', $sekolah->desa_kelurahan],
            ['Kecamatan', $sekolah->kecamatan],
            ['Kabupaten', $sekolah->kabupaten],
            ['Provinsi', $sekolah->provinsi],
            ['Kode Pos', $sekolah->kode_pos],
        ];

        $sarana = [
            ['Luas Tanah', $isi($sekolah->laus_tanah, ' m²')],
            ['Luas Bangunan', $isi($sekolah->laus_bangunan, ' m²')],
            ['Tipe Internet', $isi($sekolah->tipe_internet)],
            ['Provider Internet', $isi($sekolah->internet_provider)],
            ['Bandwidth Internet', $isi($sekolah->bandwith_internet, ' Mbps')],
            ['Sumber Listrik', $isi($sekolah->sumber_listrik)],
            ['Daya Listrik', $isi($sekolah->daya_listrik, ' VA')],
            ['Sumber Air', $isi($sekolah->sumber_air)],
        ];

        $dokumen = ['SK Pendirian Sekolah', 'SK Izin Operasional', 'SK Akreditasi Sekolah'];

        $stat = [
            [
                'bi-people',
                'Jumlah Siswa',
                $sekolah->siswas_count,
                'border-sky-200 bg-sky-50 dark:border-sky-500/30 dark:bg-sky-500/10',
                'bg-sky-500',
            ],
            [
                'bi-person-workspace',
                'Guru (Tenaga Pendidik)',
                $guru,
                'border-violet-200 bg-violet-50 dark:border-violet-500/30 dark:bg-violet-500/10',
                'bg-violet-500',
            ],
            [
                'bi-person-badge',
                'TU (Tenaga Kependidikan)',
                $tu,
                'border-emerald-200 bg-emerald-50 dark:border-emerald-500/30 dark:bg-emerald-500/10',
                'bg-emerald-500',
            ],
            [
                'bi-trophy',
                'Prestasi',
                $prestasis->count(),
                'border-amber-200 bg-amber-50 dark:border-amber-500/30 dark:bg-amber-500/10',
                'bg-amber-500',
            ],
        ];

        $warnaStatus = [
            'PNS' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-300',
            'PPPK' => 'bg-sky-100 text-sky-700 dark:bg-sky-500/20 dark:text-sky-300',
            'PPPK Paruh Waktu' => 'bg-cyan-100 text-cyan-700 dark:bg-cyan-500/20 dark:text-cyan-300',
            'Non-ASN' => 'bg-amber-100 text-amber-700 dark:bg-amber-500/20 dark:text-amber-300',
            'Honorer' => 'bg-orange-100 text-orange-700 dark:bg-orange-500/20 dark:text-orange-300',
        ];
        $warnaStatusLain = 'bg-slate-100 text-slate-600 dark:bg-slate-500/20 dark:text-slate-300';

        $judulKartu = 'font-semibold';
        $ikonKartu = 'me-1';
        $barisDl = 'flex justify-between gap-4 py-2';
        $nilaiDl = 'min-w-0 break-words text-right font-medium';

    @endphp

    <x-breadcrumb :items="[
        ['label' => 'Data Sekolah', 'url' => route('admin.sekolah.index')],
        ['label' => $sekolah->nama_sekolah],
    ]" />


    {{-- ===== Header profil: logo + identitas singkat + statistik ===== --}}
    <div
        class="rounded-xl border border-gray-200 bg-linear-to-r from-emerald-50 via-white to-sky-50 p-4 dark:border-gray-800 dark:from-emerald-500/10 dark:via-gray-900 dark:to-sky-500/10 sm:p-6">
        <div class="flex flex-col items-center gap-4 text-center sm:flex-row sm:items-start sm:text-left">
            <span
                class="inline-flex h-24 w-24 shrink-0 items-center justify-center rounded-2xl bg-linear-to-br from-emerald-500 to-sky-500 text-4xl text-white shadow-md">
                <i class="bi bi-building"></i>
            </span>

            <div class="min-w-0 flex-1">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100 sm:text-xl">
                    {{ $sekolah->nama_sekolah }}</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    NPSN {{ $sekolah->npsn }} &middot; NSS {{ $sekolah->nss }}
                </p>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    <i class="bi bi-geo-alt me-1 text-rose-500"></i>
                    {{ $sekolah->kecamatan }}, {{ $sekolah->kabupaten }}, {{ $sekolah->provinsi }}
                </p>
                <div class="mt-2 flex flex-wrap justify-center gap-1.5 sm:justify-start">
                    <x-badge :variant="$sekolah->akreditasi === '-' ? 'secondary' : 'success'"
                        pill>{{ $sekolah->akreditasi === '-' ? 'Tidak Terakreditasi' : 'Akreditasi ' . $sekolah->akreditasi }}</x-badge>
                    <x-badge :variant="$sekolah->status_sekolah === 'Negeri' ? 'primary' : 'warning'" pill>{{ $sekolah->status_sekolah }}</x-badge>
                </div>
            </div>

            <div class="flex w-full shrink-0 gap-2 sm:w-auto">
                <x-button href="{{ route('admin.sekolah.index') }}" variant="light" size="sm"
                    class="flex-1 sm:flex-none">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </x-button>
                <x-button href="{{ route('admin.sekolah.edit', $sekolah) }}" size="sm" class="flex-1 sm:flex-none">
                    <i class="bi bi-pencil-fill me-1"></i> Edit Profil
                </x-button>
            </div>
        </div>

        <div class="mt-5 grid grid-cols-2 gap-3 lg:grid-cols-4">
            @foreach ($stat as [$ikon, $label, $nilai, $kotak, $warnaIkon])
                <div class="flex min-w-0 items-center gap-3 rounded-lg border p-3 {{ $kotak }}">
                    <span
                        class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-lg text-white shadow-sm {{ $warnaIkon }}">
                        <i class="bi {{ $ikon }}"></i>
                    </span>
                    <div class="min-w-0">
                        <p class="truncate text-xs text-gray-500 dark:text-gray-400">{{ $label }}</p>
                        <p class="truncate text-base font-semibold">{{ $nilai }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- ===== Konten utama: kiri (visi-misi, identitas, prestasi) | kanan (alamat, sarana, dokumen) ===== --}}
    <div class="grid grid-cols-1 gap-4 lg:grid-cols-3">
        <div class="flex min-w-0 flex-col gap-4 lg:col-span-2">

            {{-- Visi & Misi --}}
            <x-card>
                <x-slot:header>
                    <span class="{{ $judulKartu }}"><i
                            class="bi bi-bullseye {{ $ikonKartu }} text-violet-600 dark:text-violet-400"></i> Visi &
                        Misi</span>
                </x-slot:header>
                <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                    <div>
                        <h4 class="mb-2 text-sm font-semibold text-violet-700 dark:text-violet-300">Visi</h4>
                        @if (filled($sekolah->visi))
                            <p class="border-l-2 border-violet-500 ps-3 text-sm leading-relaxed italic">
                                {{ $sekolah->visi }}</p>
                        @else
                            <p class="text-sm text-gray-500 dark:text-gray-400">Belum diisi.</p>
                        @endif
                    </div>
                    <div>
                        <h4 class="mb-2 text-sm font-semibold text-violet-700 dark:text-violet-300">Misi</h4>
                        @if ($daftarMisi)
                            <ol
                                class="list-decimal space-y-1.5 wrap-break-word ps-5 text-sm leading-relaxed marker:font-semibold marker:text-violet-600">
                                @foreach ($daftarMisi as $misi)
                                    <li>{{ $misi }}</li>
                                @endforeach
                            </ol>
                        @else
                            <p class="text-sm text-gray-500 dark:text-gray-400">Belum diisi.</p>
                        @endif
                    </div>
                </div>
            </x-card>

            {{-- Identitas --}}
            <x-card>
                <x-slot:header>
                    <span class="{{ $judulKartu }}"><i
                            class="bi bi-card-text {{ $ikonKartu }} text-emerald-600 dark:text-emerald-400"></i>
                        Identitas
                        Sekolah</span>
                </x-slot:header>
                <dl class="grid grid-cols-1 gap-x-8 text-sm sm:grid-cols-2">
                    @foreach ($identitas as [$label, $nilai])
                        <div class="{{ $barisDl }} border-b border-gray-200 dark:border-gray-700">
                            <dt class="shrink-0 text-gray-500 dark:text-gray-400">{{ $label }}</dt>
                            <dd class="{{ $nilaiDl }}">{{ $nilai }}</dd>
                        </div>
                    @endforeach
                </dl>
            </x-card>

            {{-- Prestasi --}}
            <x-card>
                <x-slot:header>
                    <span class="{{ $judulKartu }}"><i
                            class="bi bi-trophy {{ $ikonKartu }} text-amber-600 dark:text-amber-400"></i> Prestasi
                        Sekolah</span>
                </x-slot:header>
                <ul class="divide-y divide-gray-200 text-sm dark:divide-gray-700">
                    @forelse ($prestasis as $prestasi)
                        <li class="flex items-center justify-between gap-3 py-2.5">
                            <div class="flex min-w-0 items-center gap-3">
                                <span
                                    class="inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-md bg-amber-50 text-amber-600 dark:bg-amber-500/15 dark:text-amber-300">
                                    <i class="bi bi-award"></i>
                                </span>
                                <div class="min-w-0">
                                    <p class="wrap-break-word font-medium">{{ $prestasi->prestasi }}</p>
                                    <x-badge :variant="$prestasi->jenis === 'Akademik' ? 'success' : 'secondary'" pill>
                                        {{ $prestasi->jenis }}</x-badge>
                                </div>
                            </div>
                        </li>
                    @empty
                        <li class="py-6 text-center text-gray-500 dark:text-gray-400">Belum ada prestasi. Isi lewat Edit
                            Profil.</li>
                    @endforelse
                </ul>
            </x-card>
        </div>

        <div class="grid min-w-0 grid-cols-1 content-start gap-4 md:grid-cols-2 lg:grid-cols-1">
            <x-card>
                <x-slot:header>
                    <span class="{{ $judulKartu }}"><i
                            class="bi bi-geo-alt {{ $ikonKartu }} text-rose-600 dark:text-rose-400"></i>
                        Alamat</span>
                </x-slot:header>
                <dl class="divide-y divide-gray-200 text-sm dark:divide-gray-700">
                    @foreach ($alamat as [$label, $nilai])
                        <div class="{{ $barisDl }}">
                            <dt class="shrink-0 text-gray-500 dark:text-gray-400">{{ $label }}</dt>
                            <dd class="{{ $nilaiDl }}">{{ $nilai }}</dd>
                        </div>
                    @endforeach
                </dl>
            </x-card>

            <x-card>
                <x-slot:header>
                    <span class="{{ $judulKartu }}"><i
                            class="bi bi-lightning-charge {{ $ikonKartu }} text-sky-600 dark:text-sky-400"></i>
                        Sarana Pendukung</span>
                </x-slot:header>
                <dl class="divide-y divide-gray-200 text-sm dark:divide-gray-700">
                    @foreach ($sarana as [$label, $nilai])
                        <div class="{{ $barisDl }}">
                            <dt class="shrink-0 text-gray-500 dark:text-gray-400">{{ $label }}</dt>
                            <dd class="{{ $nilaiDl }}">{{ $nilai }}</dd>
                        </div>
                    @endforeach
                </dl>
            </x-card>

            <x-card class="md:col-span-2 lg:col-span-1">
                <x-slot:header>
                    <span class="{{ $judulKartu }}"><i
                            class="bi bi-file-earmark-text {{ $ikonKartu }} text-orange-600 dark:text-orange-400"></i>
                        Dokumen SK</span>
                </x-slot:header>
                <dl class="divide-y divide-gray-200 text-sm dark:divide-gray-700">
                    @foreach ($dokumen as $nama)
                        <div class="flex items-center justify-between gap-3 py-2.5">
                            <dt class="flex min-w-0 items-center gap-2 text-gray-600 dark:text-gray-300">
                                <i class="bi bi-file-earmark-pdf shrink-0 text-base text-rose-500"></i>
                                <span class="truncate">{{ $nama }}</span>
                            </dt>
                            <dd>
                                <x-button href="#" size="xs" target="_blank">Lihat</x-button>
                            </dd>
                        </div>
                    @endforeach
                </dl>
            </x-card>
        </div>
    </div>

    {{-- ===== Data siswa ===== --}}
    <div class="flex items-center gap-2 pt-2">
        <span class="h-5 w-1 rounded-full bg-sky-500"></span>
        <h3 class="font-semibold">Data Siswa</h3>
    </div>

    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
        <x-card>
            <x-slot:header>
                <span class="{{ $judulKartu }}"><i
                        class="bi bi-gender-ambiguous {{ $ikonKartu }} text-sky-600 dark:text-sky-400"></i> Rasio
                    Jenis Kelamin</span>
            </x-slot:header>
            <div class="mx-auto h-56 max-w-xs sm:h-64">
                <canvas id="grafikJk"></canvas>
            </div>
        </x-card>

        <x-card>
            <x-slot:header>
                <span class="{{ $judulKartu }}"><i
                        class="bi bi-mortarboard {{ $ikonKartu }} text-violet-600 dark:text-violet-400"></i> Siswa
                    per
                    Kelas</span>
            </x-slot:header>
            <div class="mx-auto h-56 max-w-xs sm:h-64">
                <canvas id="grafikKelas"></canvas>
            </div>
        </x-card>
    </div>

    <x-card>
        <x-slot:header>
            <div class="flex flex-wrap items-center justify-between gap-2">
                <span class="font-semibold">
                    <i class="bi bi-people-fill me-2 text-emerald-500"></i>Daftar Siswa
                    <span
                        class="ms-1 rounded-full bg-emerald-100 px-2 py-0.5 text-xs font-semibold text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-300">{{ $siswas->total() }}</span>
                </span>
                <div class="flex gap-2">
                    <x-button href="{{ route('admin.siswa.sekolah', $sekolah->id) }}" variant="light" size="sm">
                        <i class="bi bi-gear me-1"></i> Kelola Siswa
                    </x-button>
                    <x-button href="{{ route('admin.siswa.create', ['sekolah_id' => $sekolah->id]) }}" size="sm">
                        <i class="bi bi-plus-lg me-1"></i> Tambah
                    </x-button>
                </div>
            </div>
        </x-slot:header>

        <x-table striped hover bordered class="text-sm">
            <x-slot:head>
                <tr>
                    <x-table.heading class="text-center">No</x-table.heading>
                    <x-table.heading class="text-center">NIK</x-table.heading>
                    <x-table.heading class="text-center">NISN</x-table.heading>
                    <x-table.heading class="min-w-48 text-center">Nama Siswa</x-table.heading>
                    <x-table.heading class="text-center">Kelas</x-table.heading>
                    <x-table.heading class="text-center">L/P</x-table.heading>
                    <x-table.heading class="text-center">Status Pelajar</x-table.heading>
                    <x-table.heading class="min-w-24 text-center">Aksi</x-table.heading>
                </tr>
            </x-slot:head>

            @forelse ($siswas as $siswa)
                <x-table.row>
                    <x-table.cell class="text-center">{{ $siswas->firstItem() + $loop->index }}</x-table.cell>
                    <x-table.cell class="whitespace-nowrap">{{ $siswa->nik }}</x-table.cell>
                    <x-table.cell class="whitespace-nowrap">{{ $siswa->nisn }}</x-table.cell>
                    <x-table.cell
                        class="font-medium text-indigo-700 dark:text-indigo-300">{{ $siswa->nama_siswa }}</x-table.cell>
                    <x-table.cell class="text-center">{{ $siswa->kelas }}</x-table.cell>
                    <x-table.cell
                        class="text-center font-semibold {{ $siswa->jenis_kelamin === 'L' ? 'text-sky-600 dark:text-sky-300' : 'text-rose-500 dark:text-rose-300' }}">{{ $siswa->jenis_kelamin }}</x-table.cell>
                    <x-table.cell class="text-center">
                        <x-badge :variant="$siswa->status_pelajar === 'Aktif' ? 'success' : 'secondary'" pill>{{ $siswa->status_pelajar }}</x-badge>
                    </x-table.cell>
                    <x-table.cell class="text-center whitespace-nowrap">
                        <div class="inline-flex items-center gap-1">
                            <a href="{{ route('admin.siswa.show', $siswa) }}" title="Detail"
                                class="rounded border border-sky-200 bg-sky-50 px-2 py-1 text-sky-600 hover:bg-sky-100 dark:border-sky-500/30 dark:bg-sky-500/10 dark:text-sky-300 dark:hover:bg-sky-500/20">
                                <i class="bi bi-eye-fill"></i>
                            </a>
                            <a href="{{ route('admin.siswa.edit', $siswa) }}" title="Edit"
                                class="rounded border border-amber-200 bg-amber-50 px-2 py-1 text-amber-600 hover:bg-amber-100 dark:border-amber-500/30 dark:bg-amber-500/10 dark:text-amber-300 dark:hover:bg-amber-500/20">
                                <i class="bi bi-pencil-fill"></i>
                            </a>
                        </div>
                    </x-table.cell>
                </x-table.row>
            @empty
                <x-table.empty colspan="8" />
            @endforelse
        </x-table>

        <x-pagination :paginator="$siswas" class="mt-4" />
    </x-card>

    {{-- ===== Data pegawai ===== --}}
    <div class="flex items-center gap-2 pt-2">
        <span class="h-5 w-1 rounded-full bg-violet-500"></span>
        <h3 class="font-semibold">Data Pegawai</h3>
    </div>

    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-3">
        <x-card>
            <x-slot:header>
                <span class="{{ $judulKartu }}"><i
                        class="bi bi-person-workspace {{ $ikonKartu }} text-emerald-600 dark:text-emerald-400"></i>
                    Status
                    Guru/TU</span>
            </x-slot:header>
            <div class="mx-auto h-56 max-w-xs sm:h-64">
                <canvas id="grafikJabatan"></canvas>
            </div>
        </x-card>

        <x-card>
            <x-slot:header>
                <span class="{{ $judulKartu }}"><i
                        class="bi bi-award {{ $ikonKartu }} text-amber-600 dark:text-amber-400"></i> Status
                    Golongan</span>
            </x-slot:header>
            <div class="mx-auto h-56 max-w-xs sm:h-64">
                <canvas id="grafikGolongan"></canvas>
            </div>
        </x-card>

        <x-card class="md:col-span-2 xl:col-span-1">
            <x-slot:header>
                <span class="{{ $judulKartu }}"><i
                        class="bi bi-patch-check {{ $ikonKartu }} text-rose-600 dark:text-rose-400"></i> Status
                    Kepegawaian</span>
            </x-slot:header>
            <div class="mx-auto h-56 max-w-xs sm:h-64">
                <canvas id="grafikStatus"></canvas>
            </div>
        </x-card>
    </div>

    <x-card>
        <x-slot:header>
            <div class="flex flex-wrap items-center justify-between gap-2">
                <span class="flex flex-wrap items-center gap-2 font-semibold">
                    <span><i class="bi bi-person-badge-fill me-2 text-amber-500"></i>Daftar Pegawai</span>
                    <span
                        class="rounded-full bg-indigo-100 px-2 py-0.5 text-xs font-semibold text-indigo-700 dark:bg-indigo-500/20 dark:text-indigo-300">Guru
                        {{ $guru }}</span>
                    <span
                        class="rounded-full bg-amber-100 px-2 py-0.5 text-xs font-semibold text-amber-700 dark:bg-amber-500/20 dark:text-amber-300">TU
                        {{ $tu }}</span>
                </span>
                <div class="flex gap-2">
                    <x-button href="{{ route('admin.pegawai.index') }}" variant="light" size="sm">
                        <i class="bi bi-gear me-1"></i> Kelola Pegawai
                    </x-button>
                    <x-button href="{{ route('admin.pegawai.create', ['sekolah_id' => $sekolah->id]) }}" size="sm">
                        <i class="bi bi-plus-lg me-1"></i> Tambah
                    </x-button>
                </div>
            </div>
        </x-slot:header>

        <x-table striped hover bordered class="text-sm">
            <x-slot:head>
                <tr>
                    <x-table.heading class="text-center">No</x-table.heading>
                    <x-table.heading class="text-center">NIP</x-table.heading>
                    <x-table.heading class="min-w-48 text-center">Nama</x-table.heading>
                    <x-table.heading class="text-center">L/P</x-table.heading>
                    <x-table.heading class="text-center">Jabatan</x-table.heading>
                    <x-table.heading class="text-center">Tugas</x-table.heading>
                    <x-table.heading class="text-center">Status Kepegawaian</x-table.heading>
                    <x-table.heading class="min-w-24 text-center">Aksi</x-table.heading>
                </tr>
            </x-slot:head>

            @forelse ($pegawais as $pegawai)
                <x-table.row>
                    <x-table.cell class="text-center">{{ $pegawais->firstItem() + $loop->index }}</x-table.cell>
                    <x-table.cell class="whitespace-nowrap">{{ $pegawai->nip ?: '-' }}</x-table.cell>
                    <x-table.cell
                        class="font-medium text-indigo-700 dark:text-indigo-300">{{ $pegawai->nama }}</x-table.cell>
                    <x-table.cell
                        class="text-center font-semibold {{ $pegawai->jenis_kelamin === 'L' ? 'text-sky-600 dark:text-sky-300' : 'text-rose-500 dark:text-rose-300' }}">{{ $pegawai->jenis_kelamin }}</x-table.cell>
                    <x-table.cell class="whitespace-nowrap text-center">
                        <span
                            class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $pegawai->jabatan === 'Tenaga Pendidik' ? 'bg-indigo-100 text-indigo-700 dark:bg-indigo-500/20 dark:text-indigo-300' : 'bg-amber-100 text-amber-700 dark:bg-amber-500/20 dark:text-amber-300' }}">{{ $pegawai->jabatan }}</span>
                    </x-table.cell>
                    <x-table.cell>{{ $pegawai->tugas }}</x-table.cell>
                    <x-table.cell class="whitespace-nowrap text-center">
                        <span
                            class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $warnaStatus[$pegawai->status_kepegawaian] ?? $warnaStatusLain }}">{{ $pegawai->status_kepegawaian }}</span>
                    </x-table.cell>
                    <x-table.cell class="text-center whitespace-nowrap">
                        <div class="inline-flex items-center gap-1">
                            <a href="{{ route('admin.pegawai.show', $pegawai) }}" title="Detail"
                                class="rounded border border-sky-200 bg-sky-50 px-2 py-1 text-sky-600 hover:bg-sky-100 dark:border-sky-500/30 dark:bg-sky-500/10 dark:text-sky-300 dark:hover:bg-sky-500/20">
                                <i class="bi bi-eye-fill"></i>
                            </a>
                            <a href="{{ route('admin.pegawai.edit', $pegawai) }}" title="Edit"
                                class="rounded border border-amber-200 bg-amber-50 px-2 py-1 text-amber-600 hover:bg-amber-100 dark:border-amber-500/30 dark:bg-amber-500/10 dark:text-amber-300 dark:hover:bg-amber-500/20">
                                <i class="bi bi-pencil-fill"></i>
                            </a>
                        </div>
                    </x-table.cell>
                </x-table.row>
            @empty
                <x-table.empty colspan="8" />
            @endforelse
        </x-table>

        <x-pagination :paginator="$pegawais" class="mt-4" />
    </x-card>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <script>
        Chart.defaults.color = document.documentElement.classList.contains('dark') ? '#d1d5db' : '#4b5563';

        const palet = ['#059669', '#0ea5e9', '#f59e0b', '#f43f5e', '#8b5cf6', '#64748b'];

        // Plugin: angka di tiap irisan + total di tengah donat
        const angka = (judul) => ({
            id: 'angka',
            afterDatasetsDraw(chart) {
                const ctx = chart.ctx;
                const data = chart.data.datasets[0].data;
                const gelap = document.documentElement.classList.contains('dark');

                ctx.save();
                ctx.textAlign = 'center';
                ctx.textBaseline = 'middle';

                ctx.fillStyle = '#fff';
                ctx.font = '700 12px sans-serif';
                chart.getDatasetMeta(0).data.forEach((irisan, i) => {
                    if (!data[i] || irisan.circumference < 0.3) return; // irisan terlalu kecil: lewati
                    const p = irisan.tooltipPosition();
                    ctx.fillText(data[i], p.x, p.y);
                });

                const a = chart.chartArea;
                const x = (a.left + a.right) / 2;
                const y = (a.top + a.bottom) / 2;
                ctx.fillStyle = gelap ? '#f1f5f9' : '#1e293b';
                ctx.font = '700 24px sans-serif';
                ctx.fillText(data.reduce((jumlah, n) => jumlah + n, 0), x, y - 7);
                ctx.fillStyle = gelap ? '#94a3b8' : '#64748b';
                ctx.font = '400 11px sans-serif';
                ctx.fillText(judul, x, y + 14);
                ctx.restore();
            },
        });

        // warnaLabel: warna khusus per label (yang tidak disebut memakai palet)
        const donat = (id, data, judul, warnaLabel = {}) => new Chart(document.getElementById(id), {
            type: 'doughnut',
            data: {
                labels: Object.entries(data).map(([k, v]) => `${k} (${v})`),
                datasets: [{
                    data: Object.values(data),
                    backgroundColor: Object.keys(data).map((k, i) => warnaLabel[k] ?? palet[i % palet
                        .length]),
                }],
            },
            options: {
                maintainAspectRatio: false,
                cutout: '60%',
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                },
            },
            plugins: [angka(judul)],
        });

        donat('grafikJk', @json($grafikJk), 'Siswa', {
            'Laki-laki': '#3b82f6',
            'Perempuan': '#f43f5e'
        });
        donat('grafikKelas', @json($grafikKelas), 'Siswa');
        donat('grafikJabatan', @json($grafikJabatan), 'Pegawai');
        donat('grafikGolongan', @json($grafikGolongan), 'Pegawai');
        donat('grafikStatus', @json($grafikStatus), 'Pegawai');
    </script>
@endsection
