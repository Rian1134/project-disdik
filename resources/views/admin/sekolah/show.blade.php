@extends('layouts.admin')

@section('title', 'Detail Sekolah')

@section('content')
    @php
        // Daftar siswa sekolah ini. Idealnya dikirim dari controller sebagai $siswas;
        // jika belum, diambil di sini (15 per halaman, parameter halaman: siswa_page).
        $siswas =
            $siswas ??
            $sekolah
                ->siswas()
                ->orderBy('kelas')
                ->orderBy('nama_siswa')
                ->paginate(15, ['*'], 'siswa_page')
                ->withQueryString();

        // Daftar pegawai sekolah ini (guru dulu, lalu TU; 10 per halaman, parameter: pegawai_page).
        $pegawais =
            $pegawais ??
            \App\Models\Pegawai::where('sekolah_id', $sekolah->id)
                ->orderByDesc('jabatan')
                ->orderBy('nama')
                ->paginate(10, ['*'], 'pegawai_page')
                ->withQueryString();

        // Tiap kelompok = satu kartu. Tambah / ubah baris cukup di sini.
        $kelompok = [
            [
                'judul' => 'Identitas Sekolah',
                'ikon' => 'bi-building',
                'warna' => 'text-indigo-600 dark:text-indigo-400',
                'baris' => [
                    ['Nama Sekolah', $sekolah->nama_sekolah],
                    ['Nomor Statistik Sekolah', $sekolah->nss],
                    ['Nomor Pokok Sekolah Nasional', $sekolah->npsn],
                    ['Nama Kepala Sekolah', $sekolah->nama_kepala_sekolah],
                    ['Status Akreditasi', $sekolah->akreditasi],
                    ['Status Kepemilikan', $sekolah->status_sekolah],
                    ['Tanggal SK Pendirian', $sekolah->tanggal_sk_pendirian],
                    ['Tanggal SK Izin Operasional', $sekolah->tanggal_sk_izin_oprasional],
                    ['Implementasi Kurikulum', $sekolah->implementasi_kurikulum],
                ],
            ],
            [
                'judul' => 'Alamat',
                'ikon' => 'bi-geo-alt',
                'warna' => 'text-emerald-600 dark:text-emerald-400',
                'baris' => [
                    ['Alamat', $sekolah->alamat],
                    ['RT/RW', $sekolah->rt_rw],
                    ['Desa/Kelurahan', $sekolah->desa_kelurahan],
                    ['Kecamatan', $sekolah->kecamatan],
                    ['Kabupaten', $sekolah->kabupaten],
                    ['Provinsi', $sekolah->provinsi],
                    ['Kode Pos', $sekolah->kode_pos],
                ],
            ],
            [
                'judul' => 'Sarana Pendukung',
                'ikon' => 'bi-lightning-charge',
                'warna' => 'text-amber-500',
                'baris' => [
                    ['Luas Tanah', filled($sekolah->laus_tanah) ? $sekolah->laus_tanah . ' m²' : null],
                    ['Luas Bangunan', filled($sekolah->laus_bangunan) ? $sekolah->laus_bangunan . ' m²' : null],
                    ['Tipe Internet', $sekolah->tipe_internet],
                    ['Provider Internet', $sekolah->internet_provider],
                    ['Bandwidth Internet', $sekolah->bandwith_internet ? $sekolah->bandwith_internet . ' Mbps' : null],
                    ['Sumber Listrik', $sekolah->sumber_listrik],
                    ['Daya Listrik', $sekolah->daya_listrik ? $sekolah->daya_listrik . ' VA' : null],
                    ['Sumber Air', $sekolah->sumber_air],
                ],
            ],
        ];

        $dokumen = ['SK Pendirian Sekolah', 'SK Izin Operasional', 'SK Akreditasi Sekolah'];

        $warnaStatus = [
            'PNS' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-300',
            'PPPK' => 'bg-sky-100 text-sky-700 dark:bg-sky-500/20 dark:text-sky-300',
            'PPPK Paruh Waktu' => 'bg-cyan-100 text-cyan-700 dark:bg-cyan-500/20 dark:text-cyan-300',
            'Non-ASN' => 'bg-amber-100 text-amber-700 dark:bg-amber-500/20 dark:text-amber-300',
            'Honorer' => 'bg-orange-100 text-orange-700 dark:bg-orange-500/20 dark:text-orange-300',
        ];
        $warnaStatusLain = 'bg-slate-100 text-slate-600 dark:bg-slate-500/20 dark:text-slate-300';
    @endphp

    <x-breadcrumb :items="[
        ['label' => 'Data Sekolah', 'url' => route('admin.sekolah.index')],
        ['label' => $sekolah->nama_sekolah],
    ]" />

    {{-- ===== Header sekolah ===== --}}
    <x-card>
        <div class="flex flex-col gap-4 border-l-4 border-indigo-500 pl-4 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex min-w-0 items-center gap-3">
                <x-avatar :name="$sekolah->nama_sekolah" size="lg" rounded="md" />
                <div class="min-w-0">
                    <h2 class="truncate text-lg font-bold text-indigo-700 dark:text-indigo-300">{{ $sekolah->nama_sekolah }}
                    </h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">NPSN {{ $sekolah->npsn }} &middot; NSS
                        {{ $sekolah->nss }}</p>
                    <div class="mt-1 flex flex-wrap gap-1">
                        <x-badge :variant="$sekolah->status_sekolah === 'Negeri' ? 'primary' : 'warning'" pill>{{ $sekolah->status_sekolah }}</x-badge>
                        <x-badge variant="success" pill>Akreditasi {{ $sekolah->akreditasi }}</x-badge>
                    </div>
                </div>
            </div>
            <div class="flex gap-2">
                <x-button href="{{ route('admin.sekolah.index') }}" variant="light"
                    class="flex-1 sm:flex-none">Kembali</x-button>
                <x-button href="{{ route('admin.sekolah.edit', $sekolah) }}" class="flex-1 sm:flex-none">
                    <i class="bi bi-pencil-fill me-1"></i> Edit
                </x-button>
            </div>
        </div>
    </x-card>

    {{-- ===== Ringkasan jumlah ===== --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
        <x-card>
            <div class="flex items-center gap-3">
                <span
                    class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-lg border border-indigo-200 bg-indigo-100 text-lg text-indigo-600 dark:border-indigo-500/30 dark:bg-indigo-500/20 dark:text-indigo-300">
                    <i class="bi bi-people"></i>
                </span>
                <div class="min-w-0">
                    <p class="truncate text-xs text-gray-500 dark:text-gray-400">Jumlah Siswa</p>
                    <p class="text-2xl font-bold text-indigo-600 dark:text-indigo-300">{{ $sekolah->siswas_count }}</p>
                </div>
            </div>
        </x-card>
        <x-card>
            <div class="flex items-center gap-3">
                <span
                    class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-lg border border-emerald-200 bg-emerald-100 text-lg text-emerald-600 dark:border-emerald-500/30 dark:bg-emerald-500/20 dark:text-emerald-300">
                    <i class="bi bi-person-workspace"></i>
                </span>
                <div class="min-w-0">
                    <p class="truncate text-xs text-gray-500 dark:text-gray-400">Guru (Tenaga Pendidik)</p>
                    <p class="text-2xl font-bold text-emerald-600 dark:text-emerald-300">{{ $guru }}</p>
                </div>
            </div>
        </x-card>
        <x-card>
            <div class="flex items-center gap-3">
                <span
                    class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-lg border border-amber-200 bg-amber-100 text-lg text-amber-600 dark:border-amber-500/30 dark:bg-amber-500/20 dark:text-amber-300">
                    <i class="bi bi-person-badge"></i>
                </span>
                <div class="min-w-0">
                    <p class="truncate text-xs text-gray-500 dark:text-gray-400">TU (Tenaga Kependidikan)</p>
                    <p class="text-2xl font-bold text-amber-600 dark:text-amber-300">{{ $tu }}</p>
                </div>
            </div>
        </x-card>
    </div>

    {{-- ===== Detail ===== --}}
    <div class="grid grid-cols-1 items-start gap-4 md:grid-cols-2 xl:grid-cols-3">
        @foreach ($kelompok as $k)
            <x-card>
                <x-slot:header>
                    <span class="font-semibold"><i
                            class="bi {{ $k['ikon'] }} me-2 {{ $k['warna'] }}"></i>{{ $k['judul'] }}</span>
                </x-slot:header>

                <dl class="divide-y divide-gray-200 text-sm dark:divide-gray-700">
                    @foreach ($k['baris'] as [$label, $nilai])
                        <div class="flex justify-between gap-4 py-2">
                            <dt class="shrink-0 text-slate-500 dark:text-slate-400">{{ $label }}</dt>
                            <dd class="min-w-0 wrap-break-word text-right font-medium">{{ filled($nilai) ? $nilai : '-' }}</dd>
                        </div>
                    @endforeach
                </dl>
            </x-card>
        @endforeach
    </div>

    {{-- ===== Dokumen SK ===== --}}
    <x-card>
        <x-slot:header>
            <span class="font-semibold"><i class="bi bi-file-earmark-text me-2 text-rose-500"></i>Dokumen SK</span>
        </x-slot:header>

        <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
            @foreach ($dokumen as $nama)
                <div
                    class="flex items-center justify-between gap-3 rounded-lg border border-rose-100 bg-rose-50/60 p-3 text-sm dark:border-rose-500/20 dark:bg-rose-500/5">
                    <span class="min-w-0 font-medium text-slate-600 dark:text-slate-300">{{ $nama }}</span>
                    <x-button href="#" size="xs" target="_blank" class="shrink-0">
                        <i class="bi bi-box-arrow-up-right me-1"></i> Lihat SK
                    </x-button>
                </div>
            @endforeach
        </div>
    </x-card>

    {{-- ===== Daftar pegawai sekolah ===== --}}
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
                <tr class="bg-indigo-50 text-indigo-900 dark:bg-indigo-500/20 dark:text-indigo-100">
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

    {{-- ===== Daftar siswa yang bersekolah di sini ===== --}}
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
                <tr class="bg-indigo-50 text-indigo-900 dark:bg-indigo-500/20 dark:text-indigo-100">
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
@endsection
