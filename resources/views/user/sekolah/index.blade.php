@extends('layouts.user')

@section('title', 'Data Sekolah')

@section('content')
    @if ($sekolah)
        @php
            $tgl = fn($nilai) => $nilai ? \Illuminate\Support\Carbon::parse($nilai)->translatedFormat('d F Y') : '-';
            $isi = fn($nilai, $satuan = '') => filled($nilai) ? $nilai . $satuan : '-';

            // Logo user yang sedang login dipakai sebagai logo sekolah (null jika belum upload)
            $logoSekolah = Auth::user()?->logo ? asset('storage/uploads/logo/' . Auth::user()->logo) : null;

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
                ['bi-people', 'Jumlah Siswa', $sekolah->siswas_count ?? 0],
                ['bi-bounding-box', 'Luas Tanah', $isi($sekolah->laus_tanah, ' m²')],
                ['bi-building', 'Luas Bangunan', $isi($sekolah->laus_bangunan, ' m²')],
                ['bi-lightning-charge', 'Daya Listrik', $isi($sekolah->daya_listrik, ' VA')],
            ];

            $judulKartu = 'font-semibold';
            $ikonKartu = 'me-1 text-emerald-600 dark:text-emerald-400';

            $thTabel = 'px-3 py-2 font-medium';
            $tdTabel = 'px-3 py-2';
        @endphp

        {{-- ===== Ringkasan sekolah ===== --}}
        <div class="rounded-xl border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-gray-900 sm:p-5">
            <div class="flex flex-wrap items-start justify-between gap-4">
                <div class="flex min-w-0 items-center gap-4">
                    @if ($logoSekolah)
                        <img src="{{ $logoSekolah }}" alt="Logo {{ $sekolah->nama_sekolah }}" loading="lazy"
                            class="h-16 w-16 shrink-0 rounded-2xl bg-white object-cover shadow-md ring-2 ring-emerald-500/40 ring-offset-2 ring-offset-white dark:ring-emerald-400/40 dark:ring-offset-gray-900 sm:h-20 sm:w-20">
                    @else
                        <span
                            class="inline-flex h-16 w-16 shrink-0 items-center justify-center rounded-2xl bg-linear-to-br from-emerald-500 to-teal-600 text-3xl text-white shadow-md ring-2 ring-emerald-500/40 ring-offset-2 ring-offset-white dark:ring-emerald-400/40 dark:ring-offset-gray-900 sm:h-20 sm:w-20 sm:text-4xl">
                            <i class="bi bi-building"></i>
                        </span>
                    @endif
                    <div class="min-w-0">
                        <h2 class="truncate text-lg font-semibold text-gray-800 dark:text-gray-100">
                            {{ $sekolah->nama_sekolah }}
                        </h2>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            NPSN {{ $sekolah->npsn }} &middot; NSS {{ $sekolah->nss }}
                        </p>
                        <div class="mt-2 flex flex-wrap gap-1.5">
                            <x-badge :variant="$sekolah->akreditasi === '-' ? 'secondary' : 'success'"
                                pill>{{ $sekolah->akreditasi === '-' ? 'Tidak Terakreditasi' : 'Akreditasi ' . $sekolah->akreditasi }}</x-badge>
                            <x-badge variant="secondary" pill>{{ $sekolah->status_sekolah }}</x-badge>
                        </div>
                    </div>
                </div>

                <x-button href="{{ route('user.sekolah.edit', $sekolah) }}" size="sm">
                    <i class="bi bi-pencil-fill me-1"></i> Edit
                </x-button>
            </div>

            <div class="mt-5 grid grid-cols-2 gap-3 lg:grid-cols-4">
                @foreach ($stat as [$ikon, $label, $nilai])
                    <div class="flex items-center gap-3 rounded-lg border border-gray-200 p-3 dark:border-gray-700">
                        <span
                            class="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-md bg-emerald-50 text-emerald-600 dark:bg-emerald-500/15 dark:text-emerald-300">
                            <i class="bi {{ $ikon }}"></i>
                        </span>
                        <div class="min-w-0">
                            <p class="truncate text-xs text-gray-500 dark:text-gray-400">{{ $label }}</p>
                            <p class="truncate text-sm font-semibold">{{ $nilai }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- ===== Detail ===== --}}
        <div class="grid grid-cols-1 gap-4 lg:grid-cols-3">
            <x-card>
                <x-slot:header>
                    <span class="{{ $judulKartu }}"><i class="bi bi-card-text {{ $ikonKartu }}"></i> Identitas
                        Sekolah</span>
                </x-slot:header>
                <dl class="divide-y divide-gray-200 text-sm dark:divide-gray-700">
                    @foreach ($identitas as [$label, $nilai])
                        <div class="flex justify-between gap-4 py-2">
                            <dt class="text-gray-500 dark:text-gray-400">{{ $label }}</dt>
                            <dd class="text-right font-medium">{{ $nilai }}</dd>
                        </div>
                    @endforeach
                </dl>
            </x-card>

            <x-card>
                <x-slot:header>
                    <span class="{{ $judulKartu }}"><i class="bi bi-geo-alt {{ $ikonKartu }}"></i> Alamat</span>
                </x-slot:header>
                <dl class="divide-y divide-gray-200 text-sm dark:divide-gray-700">
                    @foreach ($alamat as [$label, $nilai])
                        <div class="flex justify-between gap-4 py-2">
                            <dt class="text-gray-500 dark:text-gray-400">{{ $label }}</dt>
                            <dd class="text-right font-medium">{{ $nilai }}</dd>
                        </div>
                    @endforeach
                </dl>
            </x-card>

            <x-card>
                <x-slot:header>
                    <span class="{{ $judulKartu }}"><i class="bi bi-lightning-charge {{ $ikonKartu }}"></i> Sarana
                        Pendukung</span>
                </x-slot:header>
                <dl class="divide-y divide-gray-200 text-sm dark:divide-gray-700">
                    @foreach ($sarana as [$label, $nilai])
                        <div class="flex justify-between gap-4 py-2">
                            <dt class="text-gray-500 dark:text-gray-400">{{ $label }}</dt>
                            <dd class="text-right font-medium">{{ $nilai }}</dd>
                        </div>
                    @endforeach
                </dl>
            </x-card>
        </div>

        {{-- ===== Dokumen SK ===== --}}
        <x-card>
            <x-slot:header>
                <span class="{{ $judulKartu }}"><i class="bi bi-file-earmark-text {{ $ikonKartu }}"></i> Dokumen
                    SK</span>
            </x-slot:header>
            <dl class="divide-y divide-gray-200 text-sm dark:divide-gray-700">
                @foreach ($dokumen as $nama)
                    <div class="flex items-center justify-between gap-4 py-2.5">
                        <dt class="flex items-center gap-2 text-gray-600 dark:text-gray-300">
                            <i class="bi bi-file-earmark-pdf text-base text-rose-500"></i>
                            {{ $nama }}
                        </dt>
                        <dd>
                            <x-button href="#" size="xs" target="_blank">
                                <i class="bi bi-box-arrow-up-right me-1"></i> Lihat SK
                            </x-button>
                        </dd>
                    </div>
                @endforeach
            </dl>
        </x-card>

        <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
            <x-card>
                <x-slot:header>
                    <span class="{{ $judulKartu }}"><i class="bi bi-gender-ambiguous {{ $ikonKartu }}"></i> Rasio
                        Jenis Kelamin</span>
                </x-slot:header>
                <div class="mx-auto h-64 max-w-xs">
                    <canvas id="grafikJk"></canvas>
                </div>
            </x-card>

            <x-card>
                <x-slot:header>
                    <span class="{{ $judulKartu }}"><i class="bi bi-mortarboard {{ $ikonKartu }}"></i> Siswa per
                        Kelas</span>
                </x-slot:header>
                <div class="mx-auto h-64 max-w-xs">
                    <canvas id="grafikKelas"></canvas>
                </div>
            </x-card>
        </div>

        {{-- ===== Daftar siswa ===== --}}
        <x-card>
            <x-slot:header>
                <div class="flex items-center justify-between gap-2">
                    <span class="{{ $judulKartu }}"><i class="bi bi-people {{ $ikonKartu }}"></i> Daftar Siswa</span>
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
            <div class="mt-3 flex flex-wrap items-center justify-between gap-3">
                <p id="infoSiswa" class="text-sm text-gray-500 dark:text-gray-400"></p>
                <div id="pagerSiswa" class="flex flex-wrap items-center gap-1"></div>
            </div>
        </x-card>

        <div class="grid grid-cols-1 gap-4 lg:grid-cols-3">
            <x-card>
                <x-slot:header>
                    <span class="{{ $judulKartu }}"><i class="bi bi-person-workspace {{ $ikonKartu }}"></i> Status
                        Guru/TU</span>
                </x-slot:header>
                <div class="mx-auto h-64 max-w-xs">
                    <canvas id="grafikJabatan"></canvas>
                </div>
            </x-card>

            <x-card>
                <x-slot:header>
                    <span class="{{ $judulKartu }}"><i class="bi bi-award {{ $ikonKartu }}"></i> Status
                        Golongan</span>
                </x-slot:header>
                <div class="mx-auto h-64 max-w-xs">
                    <canvas id="grafikGolongan"></canvas>
                </div>
            </x-card>

            <x-card>
                <x-slot:header>
                    <span class="{{ $judulKartu }}"><i class="bi bi-patch-check {{ $ikonKartu }}"></i> Status
                        Kepegawaian</span>
                </x-slot:header>
                <div class="mx-auto h-64 max-w-xs">
                    <canvas id="grafikStatus"></canvas>
                </div>
            </x-card>
        </div>

        {{-- ===== Daftar pegawai ===== --}}
        <x-card>
            <x-slot:header>
                <div class="flex items-center justify-between gap-2">
                    <span class="{{ $judulKartu }}"><i class="bi bi-person-badge {{ $ikonKartu }}"></i> Daftar
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
            <div class="mt-3 flex flex-wrap items-center justify-between gap-3">
                <p id="infoPegawai" class="text-sm text-gray-500 dark:text-gray-400"></p>
                <div id="pagerPegawai" class="flex flex-wrap items-center gap-1"></div>
            </div>
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
                    Anda belum memiliki data sekolah.
                </p>
                <x-button href="{{ route('user.sekolah.create') }}">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Data Sekolah
                </x-button>
            </div>
        </x-card>
    @endif
@endsection
