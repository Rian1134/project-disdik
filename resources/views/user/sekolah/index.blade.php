@extends('layouts.user')

@section('title', 'Profil Sekolah')

@section('content')
    @if ($sekolah)
        @php
            $tgl = fn($nilai) => $nilai ? \Illuminate\Support\Carbon::parse($nilai)->translatedFormat('d F Y') : '-';
            $isi = fn($nilai, $satuan = '') => filled($nilai) ? $nilai . $satuan : '-';

            // Logo user yang sedang login dipakai sebagai logo sekolah (null jika belum upload)
            $logoSekolah = Auth::user()?->logo ? asset('storage/uploads/logo/' . Auth::user()->logo) : null;

            // Misi diisi satu poin per baris
            $daftarMisi = array_filter(array_map('trim', explode("\n", (string) $sekolah->misi)));

            $identitas = [
                ['Nama Sekolah', $sekolah->nama_sekolah],
                ['NSS', $sekolah->nss],
                ['NPSN', $sekolah->npsn],
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

            $dokumen = [
                'SK Pendirian Sekolah' => 'https://gofile.me/7Hsao/Nidxu2cSq',
                'SK Izin Operasional' => 'https://gofile.me/7Hsao/2kcagbEMI',
                'SK Akreditasi Sekolah' => 'https://gofile.me/7Hsao/Nidxu2cSq',
            ];

            $stat = [
                [
                    'bi-people',
                    'Jumlah Siswa',
                    $sekolah->siswas_count ?? 0,
                    'border-sky-200 bg-sky-50 dark:border-sky-500/30 dark:bg-sky-500/10',
                    'bg-sky-500',
                ],
                [
                    'bi-person-badge',
                    'Jumlah Pegawai',
                    $pegawais->count(),
                    'border-violet-200 bg-violet-50 dark:border-violet-500/30 dark:bg-violet-500/10',
                    'bg-violet-500',
                ],
                [
                    'bi-trophy',
                    'Prestasi',
                    $prestasis->count(),
                    'border-amber-200 bg-amber-50 dark:border-amber-500/30 dark:bg-amber-500/10',
                    'bg-amber-500',
                ],
                [
                    'bi-bounding-box',
                    'Luas Tanah',
                    $isi($sekolah->laus_tanah, ' m²'),
                    'border-emerald-200 bg-emerald-50 dark:border-emerald-500/30 dark:bg-emerald-500/10',
                    'bg-emerald-500',
                ],
            ];

            $judulKartu = 'font-semibold';
            $ikonKartu = 'me-1';
            $barisDl = 'flex justify-between gap-4 py-2';
            $nilaiDl = 'min-w-0 break-words text-right font-medium';

            $thTabel = 'whitespace-nowrap px-3 py-2 font-medium';
            $tdTabel = 'px-3 py-2';
        @endphp

        {{-- ===== Header profil: logo + identitas singkat + statistik ===== --}}
        <div
            class="rounded-xl border border-gray-200 bg-linear-to-r from-emerald-50 via-white to-sky-50 p-4 dark:border-gray-800 dark:from-emerald-500/10 dark:via-gray-900 dark:to-sky-500/10 sm:p-6">
            <div class="flex flex-col items-center gap-4 text-center sm:flex-row sm:items-start sm:text-left">
                @if ($logoSekolah)
                    <img src="{{ $logoSekolah }}" alt="Logo {{ $sekolah->nama_sekolah }}" loading="lazy"
                        class="h-24 w-24 shrink-0 rounded-2xl bg-white object-cover shadow-md ring-2 ring-emerald-500/50 ring-offset-2 ring-offset-white dark:ring-offset-gray-900">
                @else
                    <span
                        class="inline-flex h-24 w-24 shrink-0 items-center justify-center rounded-2xl bg-linear-to-br from-emerald-500 to-sky-500 text-4xl text-white shadow-md">
                        <i class="bi bi-building"></i>
                    </span>
                @endif

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
                        <x-badge variant="secondary" pill>{{ $sekolah->status_sekolah }}</x-badge>
                    </div>
                </div>

                <x-button href="{{ route('user.sekolah.edit', $sekolah) }}" size="sm" class="shrink-0">
                    <i class="bi bi-pencil-fill me-1"></i> Edit Profil
                </x-button>
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
                        @foreach ($dokumen as $nama => $link)
                            <div class="flex items-center justify-between gap-3 py-2.5">
                                <dt class="flex min-w-0 items-center gap-2 text-gray-600 dark:text-gray-300">
                                    <i class="bi bi-file-earmark-pdf shrink-0 text-base text-rose-500"></i>
                                    <span class="truncate">{{ $nama }}</span>
                                </dt>
                                <dd>
                                    <x-button href="{{ $link }}" size="xs" target="_blank">Lihat</x-button>
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
                    <span class="{{ $judulKartu }}"><i
                            class="bi bi-people {{ $ikonKartu }} text-sky-600 dark:text-sky-400"></i> Daftar
                        Siswa</span>
                    <x-button href="{{ route('user.siswa.index') }}" size="xs">
                        Lihat Semua <i class="bi bi-arrow-right ms-1"></i>
                    </x-button>
                </div>
            </x-slot:header>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="border-b border-gray-200 text-gray-500 dark:border-gray-700 dark:text-gray-400">
                        <tr>
                            <th class="{{ $thTabel }}">No</th>
                            <th class="{{ $thTabel }}">Nama</th>
                            <th class="{{ $thTabel }}">NISN</th>
                            <th class="{{ $thTabel }}">L/P</th>
                        </tr>
                    </thead>
                    <tbody id="isiSiswa" class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($siswas as $siswa)
                            <tr data-baris>
                                <td class="{{ $tdTabel }}">{{ $loop->iteration }}</td>
                                <td class="{{ $tdTabel }} font-medium">{{ $siswa->nama_siswa }}</td>
                                <td class="{{ $tdTabel }}">{{ $isi($siswa->nisn) }}</td>
                                <td class="{{ $tdTabel }}">{{ $isi($siswa->jenis_kelamin) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-3 py-6 text-center text-gray-500 dark:text-gray-400">
                                    Belum ada data siswa.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3 flex flex-col items-center justify-between gap-3 sm:flex-row">
                <p id="infoSiswa" class="text-sm text-gray-500 dark:text-gray-400"></p>
                <div id="pagerSiswa" class="flex flex-wrap items-center gap-1"></div>
            </div>
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
                <div class="relative h-56 sm:h-64">
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
                    <span class="{{ $judulKartu }}"><i
                            class="bi bi-journal-bookmark {{ $ikonKartu }} text-violet-600 dark:text-violet-400"></i>
                        Guru per Mata Pelajaran</span>
                    <x-badge variant="secondary" pill>{{ $grafikMapel->sum() }} guru mapel</x-badge>
                </div>
            </x-slot:header>
            <div class="relative h-64">
                <canvas id="grafikMapel"></canvas>
            </div>
        </x-card>

        <x-card>
            <x-slot:header>
                <div class="flex flex-wrap items-center justify-between gap-2">
                    <span class="{{ $judulKartu }}"><i
                            class="bi bi-person-badge {{ $ikonKartu }} text-violet-600 dark:text-violet-400"></i>
                        Daftar
                        Pegawai</span>
                    <x-button href="{{ route('user.pegawai.index') }}" size="xs">
                        Lihat Semua <i class="bi bi-arrow-right ms-1"></i>
                    </x-button>
                </div>
            </x-slot:header>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="border-b border-gray-200 text-gray-500 dark:border-gray-700 dark:text-gray-400">
                        <tr>
                            <th class="{{ $thTabel }}">No</th>
                            <th class="{{ $thTabel }}">Nama</th>
                            <th class="{{ $thTabel }}">NIP</th>
                            <th class="{{ $thTabel }}">Jabatan</th>
                        </tr>
                    </thead>
                    <tbody id="isiPegawai" class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($pegawais as $pegawai)
                            <tr data-baris>
                                <td class="{{ $tdTabel }}">{{ $loop->iteration }}</td>
                                <td class="{{ $tdTabel }} font-medium">{{ $pegawai->nama }}</td>
                                <td class="{{ $tdTabel }}">{{ $isi($pegawai->nip) }}</td>
                                <td class="{{ $tdTabel }}">{{ $isi($pegawai->jabatan) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-3 py-6 text-center text-gray-500 dark:text-gray-400">
                                    Belum ada data pegawai.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3 flex flex-col items-center justify-between gap-3 sm:flex-row">
                <p id="infoPegawai" class="text-sm text-gray-500 dark:text-gray-400"></p>
                <div id="pagerPegawai" class="flex flex-wrap items-center gap-1"></div>
            </div>
        </x-card>


        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
        <script>
            const gelap = () => document.documentElement.classList.contains('dark');

            Chart.defaults.font.family = 'inherit';
            Chart.defaults.font.size = 12;
            Chart.defaults.color = gelap() ? '#cbd5e1' : '#475569';
            Chart.defaults.animation.duration = 900;
            Chart.defaults.animation.easing = 'easeOutQuart';

            // Palet: emerald, sky, amber, rose, violet, teal, pink, indigo, lime, slate
            const palet = ['#10b981', '#0ea5e9', '#f59e0b', '#f43f5e', '#8b5cf6', '#14b8a6', '#ec4899', '#6366f1',
                '#84cc16', '#64748b'
            ];

            const tooltipDasar = () => ({
                backgroundColor: gelap() ? '#0f172a' : '#1e293b',
                titleColor: '#fff',
                bodyColor: '#e2e8f0',
                padding: 10,
                cornerRadius: 10,
                boxPadding: 4,
                usePointStyle: true,
            });

            const kosong = (el, ikon, teks) => {
                el.parentElement.innerHTML =
                    '<div class="flex h-full items-center justify-center text-sm text-gray-500 dark:text-gray-400">' +
                    '<i class="bi ' + ikon + ' me-2 text-lg"></i>' + teks + '</div>';
            };

            // Plugin donat: angka di tiap irisan + total di tengah
            const angka = (judul) => ({
                id: 'angka',
                afterDatasetsDraw(chart) {
                    const ctx = chart.ctx;
                    const data = chart.data.datasets[0].data;

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
                    ctx.fillStyle = gelap() ? '#f1f5f9' : '#1e293b';
                    ctx.font = '800 28px sans-serif';
                    ctx.fillText(data.reduce((jumlah, n) => jumlah + n, 0), x, y - 8);
                    ctx.fillStyle = gelap() ? '#94a3b8' : '#64748b';
                    ctx.font = '500 11px sans-serif';
                    ctx.fillText(judul, x, y + 14);
                    ctx.restore();
                },
            });

            // Plugin batang: angka di ujung tiap batang
            const nilaiBatang = (mendatar) => ({
                id: 'nilaiBatang',
                afterDatasetsDraw(chart) {
                    const ctx = chart.ctx;
                    const data = chart.data.datasets[0].data;

                    ctx.save();
                    ctx.fillStyle = gelap() ? '#f1f5f9' : '#1e293b';
                    ctx.font = '700 12px sans-serif';
                    chart.getDatasetMeta(0).data.forEach((batang, i) => {
                        if (mendatar) {
                            ctx.textAlign = 'left';
                            ctx.textBaseline = 'middle';
                            ctx.fillText(data[i], batang.x + 8, batang.y);
                        } else {
                            ctx.textAlign = 'center';
                            ctx.textBaseline = 'bottom';
                            ctx.fillText(data[i], batang.x, batang.y - 6);
                        }
                    });
                    ctx.restore();
                },
            });

            // Donat: irisan membulat, jarak antar irisan, membesar saat disorot, tooltip dengan persen.
            // warnaLabel: warna khusus per label (yang tidak disebut memakai palet)
            const donat = (id, data, judul, warnaLabel = {}) => {
                const el = document.getElementById(id);
                const label = Object.keys(data);
                const nilai = Object.values(data);
                const total = nilai.reduce((jumlah, n) => jumlah + n, 0);

                if (!total) return kosong(el, 'bi-pie-chart', 'Belum ada data');

                return new Chart(el, {
                    type: 'doughnut',
                    data: {
                        labels: label.map((k, i) => `${k} (${nilai[i]})`),
                        datasets: [{
                            data: nilai,
                            backgroundColor: label.map((k, i) => warnaLabel[k] ?? palet[i % palet.length]),
                            borderWidth: 0,
                            borderRadius: 8,
                            spacing: 4,
                            hoverOffset: 10,
                        }],
                    },
                    options: {
                        maintainAspectRatio: false,
                        cutout: '68%',
                        layout: {
                            padding: 8
                        },
                        animation: {
                            animateRotate: true,
                            animateScale: true
                        },
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    usePointStyle: true,
                                    pointStyle: 'circle',
                                    boxWidth: 8,
                                    padding: 14
                                },
                            },
                            tooltip: {
                                ...tooltipDasar(),
                                callbacks: {
                                    label: (c) =>
                                        ` ${label[c.dataIndex]}: ${c.parsed} (${Math.round(c.parsed / total * 100)}%)`,
                                },
                            },
                        },
                    },
                    plugins: [angka(judul)],
                });
            };

            // Batang: gradien warna, ujung membulat, angka di ujung batang.
            // mendatar = true cocok untuk label panjang (misalnya mata pelajaran).
            const batang = (id, data, {
                mendatar = false,
                warna = 0,
                satuan = 'pegawai'
            } = {}) => {
                const el = document.getElementById(id);
                const label = Object.keys(data);
                const nilai = Object.values(data);

                if (!nilai.reduce((jumlah, n) => jumlah + n, 0)) {
                    return kosong(el, 'bi-bar-chart', 'Belum ada data');
                }

                // Grafik mendatar menyesuaikan tinggi dengan banyaknya batang
                if (mendatar) {
                    el.parentElement.style.height = Math.max(240, label.length * 38 + 40) + 'px';
                }

                const gradien = (c) => {
                    const warnaDasar = palet[(warna + c.dataIndex) % palet.length];
                    const area = c.chart.chartArea;
                    if (!area) return warnaDasar;
                    const g = mendatar ?
                        c.chart.ctx.createLinearGradient(area.left, 0, area.right, 0) :
                        c.chart.ctx.createLinearGradient(0, area.bottom, 0, area.top);
                    g.addColorStop(0, warnaDasar + '66');
                    g.addColorStop(1, warnaDasar);
                    return g;
                };

                const garis = gelap() ? 'rgba(148,163,184,.15)' : 'rgba(100,116,139,.15)';
                const sumbuNilai = {
                    beginAtZero: true,
                    grace: '12%',
                    ticks: {
                        precision: 0
                    },
                    grid: {
                        color: garis
                    },
                    border: {
                        display: false
                    },
                };
                const sumbuLabel = {
                    grid: {
                        display: false
                    },
                    border: {
                        display: false
                    },
                    ticks: {
                        // label panjang dipotong; nama lengkap tampil di tooltip
                        callback(nilaiTik) {
                            const teks = this.getLabelForValue(nilaiTik);
                            return teks.length > 24 ? teks.slice(0, 23) + '…' : teks;
                        },
                    },
                };

                return new Chart(el, {
                    type: 'bar',
                    data: {
                        labels: label,
                        datasets: [{
                            data: nilai,
                            backgroundColor: gradien,
                            borderRadius: 8,
                            borderSkipped: false,
                            maxBarThickness: mendatar ? 26 : 44,
                            categoryPercentage: 0.8,
                        }],
                    },
                    options: {
                        indexAxis: mendatar ? 'y' : 'x',
                        maintainAspectRatio: false,
                        layout: {
                            padding: mendatar ? {
                                right: 28
                            } : {
                                top: 22
                            }
                        },
                        scales: mendatar ? {
                            x: sumbuNilai,
                            y: sumbuLabel
                        } : {
                            x: sumbuLabel,
                            y: sumbuNilai
                        },
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                ...tooltipDasar(),
                                callbacks: {
                                    label: (c) => ` ${c.parsed[mendatar ? 'x' : 'y']} ${satuan}`,
                                },
                            },
                        },
                    },
                    plugins: [nilaiBatang(mendatar)],
                });
            };

            donat('grafikJk', @json($grafikJk), 'Siswa', {
                'Laki-laki': '#3b82f6',
                'Perempuan': '#f43f5e'
            });
            donat('grafikKelas', @json($grafikKelas), 'Siswa');
            donat('grafikJabatan', @json($grafikJabatan), 'Pegawai');
            batang('grafikGolongan', @json($grafikGolongan), {
                warna: 2
            });
            donat('grafikStatus', @json($grafikStatus), 'Pegawai');
            batang('grafikMapel', @json($grafikMapel), {
                mendatar: true,
                warna: 4,
                satuan: 'guru'
            });

            // Paginasi di browser: tampilkan 5 baris per halaman.
            function paginasi(idIsi, idInfo, idPager, nama, perHalaman = 5) {
                const baris = [...document.querySelectorAll('#' + idIsi + ' tr[data-baris]')];
                const info = document.getElementById(idInfo);
                const pager = document.getElementById(idPager);
                const total = baris.length;
                const jumlahHal = Math.max(1, Math.ceil(total / perHalaman));
                let halaman = 1;

                function tampil() {
                    const awal = (halaman - 1) * perHalaman;
                    baris.forEach((tr, i) => {
                        tr.style.display = i >= awal && i < awal + perHalaman ? '' : 'none';
                        tr.cells[0].textContent = i + 1;
                    });

                    info.textContent = total ?
                        `Menampilkan ${awal + 1}–${Math.min(awal + perHalaman, total)} dari ${total} ${nama}` : '';

                    pager.innerHTML = '';
                    if (jumlahHal <= 1) return;

                    const tombol = (teks, tujuan, nonaktif, aktif) => {
                        const b = document.createElement('button');
                        b.type = 'button';
                        b.textContent = teks;
                        b.disabled = !!nonaktif;
                        b.className = 'min-w-9 rounded-md border px-2.5 py-1 text-sm transition ' +
                            (aktif ? 'border-emerald-600 bg-emerald-600 text-white' :
                                'border-gray-300 text-gray-600 hover:bg-gray-100 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700'
                            ) +
                            (nonaktif ? ' cursor-not-allowed opacity-50' : '');
                        if (!nonaktif) b.addEventListener('click', () => {
                            halaman = tujuan;
                            tampil();
                        });
                        pager.appendChild(b);
                    };

                    tombol('‹', halaman - 1, halaman === 1);
                    const mulai = Math.max(1, Math.min(halaman - 2, jumlahHal - 4));
                    for (let p = mulai; p <= Math.min(jumlahHal, mulai + 4); p++) tombol(String(p), p, false, p === halaman);
                    tombol('›', halaman + 1, halaman === jumlahHal);
                }

                tampil();
            }

            paginasi('isiSiswa', 'infoSiswa', 'pagerSiswa', 'siswa');
            paginasi('isiPegawai', 'infoPegawai', 'pagerPegawai', 'pegawai');
        </script>
    @else
        <x-card>
            <div class="flex flex-col items-center gap-3 py-10 text-center">
                <span
                    class="inline-flex h-14 w-14 items-center justify-center rounded-full bg-emerald-50 text-2xl text-emerald-600 dark:bg-emerald-500/15 dark:text-emerald-300">
                    <i class="bi bi-building-add"></i>
                </span>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Anda belum memiliki profil sekolah.
                </p>
                <x-button href="{{ route('user.sekolah.create') }}">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Profil Sekolah
                </x-button>
            </div>
        </x-card>
    @endif
@endsection
