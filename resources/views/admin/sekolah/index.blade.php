@extends('layouts.admin')

@section('title', 'Data Sekolah')

@section('content')
    {{-- ===== Kartu statistik ===== --}}
    <div class="grid grid-cols-2 gap-4 lg:grid-cols-4">
        <x-card>
            <div class="flex items-center gap-3 border-l-4 border-indigo-500 pl-3">
                <span
                    class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-indigo-100 text-lg text-indigo-600 dark:bg-indigo-500/20 dark:text-indigo-300">
                    <i class="bi bi-building"></i>
                </span>
                <div class="min-w-0">
                    <p class="truncate text-xs text-gray-500 dark:text-gray-400">Total Sekolah</p>
                    <p class="text-2xl font-bold text-indigo-600 dark:text-indigo-300">{{ $total['sekolah'] }}</p>
                </div>
            </div>
        </x-card>
        <x-card>
            <div class="flex items-center gap-3 border-l-4 border-emerald-500 pl-3">
                <span
                    class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-emerald-100 text-lg text-emerald-600 dark:bg-emerald-500/20 dark:text-emerald-300">
                    <i class="bi bi-people"></i>
                </span>
                <div class="min-w-0">
                    <p class="truncate text-xs text-gray-500 dark:text-gray-400">Total Siswa</p>
                    <p class="text-2xl font-bold text-emerald-600 dark:text-emerald-300">{{ $total['siswa'] }}</p>
                </div>
            </div>
        </x-card>
        <x-card>
            <div class="flex items-center gap-3 border-l-4 border-amber-500 pl-3">
                <span
                    class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-amber-100 text-lg text-amber-600 dark:bg-amber-500/20 dark:text-amber-300">
                    <i class="bi bi-person-workspace"></i>
                </span>
                <div class="min-w-0">
                    <p class="truncate text-xs text-gray-500 dark:text-gray-400">Guru</p>
                    <p class="text-2xl font-bold text-amber-600 dark:text-amber-300">{{ $total['guru'] }}</p>
                </div>
            </div>
        </x-card>
        <x-card>
            <div class="flex items-center gap-3 border-l-4 border-sky-500 pl-3">
                <span
                    class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-sky-100 text-lg text-sky-600 dark:bg-sky-500/20 dark:text-sky-300">
                    <i class="bi bi-person-badge"></i>
                </span>
                <div class="min-w-0">
                    <p class="truncate text-xs text-gray-500 dark:text-gray-400">Tenaga Kependidikan (TU)</p>
                    <p class="text-2xl font-bold text-sky-600 dark:text-sky-300">{{ $total['tu'] }}</p>
                </div>
            </div>
        </x-card>
    </div>

    {{-- ===== Grafik ===== --}}
    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
        <x-card>
            <x-slot:header>
                <span class="font-semibold"><i class="bi bi-pie-chart-fill me-2 text-indigo-500"></i>Status Sekolah</span>
            </x-slot:header>
            <div class="relative h-64"><canvas id="chartStatus"></canvas></div>
        </x-card>
        <x-card>
            <x-slot:header>
                <span class="font-semibold"><i class="bi bi-award-fill me-2 text-emerald-500"></i>Akreditasi Sekolah</span>
            </x-slot:header>
            <div class="relative h-64"><canvas id="chartAkreditasi"></canvas></div>
        </x-card>
    </div>

    <x-card>
        <x-slot:header>
            <span class="font-semibold"><i class="bi bi-bar-chart-fill me-2 text-amber-500"></i>Guru dan TU per Sekolah
                (halaman ini)</span>
        </x-slot:header>
        <div class="relative" style="height: {{ max(256, $sekolahs->count() * 44 + 60) }}px"><canvas
                id="chartPegawai"></canvas></div>
    </x-card>

    {{-- ===== Tabel ===== --}}
    <x-card>
        <x-slot:header>
            <div class="flex items-center justify-between gap-2">
                <span class="font-semibold"><i class="bi bi-table me-2 text-indigo-500"></i>List Sekolah</span>
                <x-button href="{{ route('admin.sekolah.create') }}" size="sm">
                    <i class="bi bi-plus-lg me-1"></i> Tambah
                </x-button>
            </div>
        </x-slot:header>

        <x-table striped hover bordered class="text-sm">
            <x-slot:head>
                <tr
                    class="bg-indigo-50 text-center align-middle text-indigo-900 dark:bg-indigo-500/20 dark:text-indigo-100">
                    <x-table.heading rowspan="2" class="text-center align-middle">No</x-table.heading>
                    <x-table.heading colspan="2" class="text-center">Nomor</x-table.heading>
                    <x-table.heading rowspan="2" class="min-w-56 text-center align-middle">Nama Sekolah</x-table.heading>
                    <x-table.heading rowspan="2" class="text-center align-middle">Jumlah Tenaga Pendidik /
                        Guru</x-table.heading>
                    <x-table.heading rowspan="2" class="text-center align-middle">Jumlah Tenaga Kependidikan /
                        TU</x-table.heading>
                    <x-table.heading rowspan="2" class="text-center align-middle">Jumlah Siswa</x-table.heading>
                    <x-table.heading rowspan="2" class="text-center align-middle">Status Sekolah</x-table.heading>
                    <x-table.heading rowspan="2" class="text-center align-middle">Akreditasi Sekolah</x-table.heading>
                    <x-table.heading rowspan="2" class="min-w-64 text-center align-middle">Alamat
                        Sekolah</x-table.heading>
                    <x-table.heading rowspan="2" class="text-center align-middle">Kecamatan</x-table.heading>
                    <x-table.heading rowspan="2" class="min-w-28 text-center align-middle">Aksi</x-table.heading>
                </tr>
                <tr class="bg-indigo-50 text-center text-indigo-900 dark:bg-indigo-500/20 dark:text-indigo-100">
                    <x-table.heading class="text-center">Statistik Sekolah (NSS)</x-table.heading>
                    <x-table.heading class="text-center">Pokok Sekolah Nasional (NPSN)</x-table.heading>
                </tr>
            </x-slot:head>

            @forelse($sekolahs as $sekolah)
                <x-table.row>
                    <x-table.cell class="text-center">{{ $sekolahs->firstItem() + $loop->index }}</x-table.cell>
                    <x-table.cell class="whitespace-nowrap">{{ $sekolah->nss }}</x-table.cell>
                    <x-table.cell class="whitespace-nowrap">{{ $sekolah->npsn }}</x-table.cell>
                    <x-table.cell
                        class="font-medium text-indigo-700 dark:text-indigo-300">{{ $sekolah->nama_sekolah }}</x-table.cell>
                    <x-table.cell
                        class="text-center font-semibold text-amber-600 dark:text-amber-300">{{ $sekolah->guru_count }}</x-table.cell>
                    <x-table.cell
                        class="text-center font-semibold text-sky-600 dark:text-sky-300">{{ $sekolah->tu_count }}</x-table.cell>
                    <x-table.cell
                        class="text-center font-semibold text-emerald-600 dark:text-emerald-300">{{ $sekolah->siswas_count }}</x-table.cell>
                    <x-table.cell class="text-center">
                        <x-badge :variant="$sekolah->status_sekolah === 'Negeri' ? 'primary' : 'warning'" pill>{{ $sekolah->status_sekolah }}</x-badge>
                    </x-table.cell>
                    <x-table.cell class="text-center">
                        <x-badge variant="success" pill>{{ $sekolah->akreditasi }}</x-badge>
                    </x-table.cell>
                    <x-table.cell class="max-w-64 truncate"
                        title="{{ $sekolah->alamat }}">{{ $sekolah->alamat }}</x-table.cell>
                    <x-table.cell>{{ $sekolah->kecamatan }}</x-table.cell>
                    <x-table.cell class="text-center whitespace-nowrap">
                        <div class="inline-flex items-center gap-1">
                            <a href="{{ route('admin.sekolah.show', $sekolah) }}" title="Detail"
                                class="rounded border border-sky-200 bg-sky-50 px-2 py-1 text-sky-600 hover:bg-sky-100 dark:border-sky-500/30 dark:bg-sky-500/10 dark:text-sky-300 dark:hover:bg-sky-500/20">
                                <i class="bi bi-eye-fill"></i>
                            </a>
                            <a href="{{ route('admin.sekolah.edit', $sekolah) }}" title="Edit"
                                class="rounded border border-amber-200 bg-amber-50 px-2 py-1 text-amber-600 hover:bg-amber-100 dark:border-amber-500/30 dark:bg-amber-500/10 dark:text-amber-300 dark:hover:bg-amber-500/20">
                                <i class="bi bi-pencil-fill"></i>
                            </a>
                            <button type="button" data-modal-open="hapus-{{ $sekolah->id }}" title="Hapus"
                                class="rounded border border-rose-200 bg-rose-50 px-2 py-1 text-rose-600 hover:bg-rose-100 dark:border-rose-500/30 dark:bg-rose-500/10 dark:text-rose-300 dark:hover:bg-rose-500/20">
                                <i class="bi bi-trash-fill"></i>
                            </button>
                        </div>

                        <x-modal id="hapus-{{ $sekolah->id }}" size="sm" centered>
                            <x-slot:header>
                                <i class="bi bi-exclamation-triangle-fill me-2 text-rose-500"></i>Konfirmasi Hapus
                            </x-slot:header>

                            <p class="text-center text-sm">
                                Yakin ingin menghapus <strong>{{ $sekolah->nama_sekolah }}</strong>?
                            </p>

                            <x-slot:footer>
                                <x-button variant="light" data-modal-close>Batal</x-button>
                                <form action="{{ route('admin.sekolah.destroy', $sekolah) }}" method="POST"
                                    class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <x-button type="submit" variant="danger">Hapus</x-button>
                                </form>
                            </x-slot:footer>
                        </x-modal>
                    </x-table.cell>
                </x-table.row>
            @empty
                <x-table.empty colspan="12" />
            @endforelse
        </x-table>

        <x-pagination :paginator="$sekolahs" class="mt-4" />
    </x-card>
@endsection

@push('scripts')
    @php
        $dataSekolah = $sekolahs
            ->getCollection()
            ->map(
                fn($s) => [
                    'nama_sekolah' => $s->nama_sekolah,
                    'guru_count' => $s->guru_count,
                    'tu_count' => $s->tu_count,
                ],
            )
            ->values();
    @endphp
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
    <script>
        (function() {
            if (typeof Chart === 'undefined') {
                console.error('Chart.js gagal dimuat (cek koneksi / CDN).');
                return;
            }

            // ---------- Data dari controller ----------
            // Dikirim sebagai object {label: jumlah}; Object.entries aman untuk object maupun array.
            const dataStatus = Object.entries(@json($status));
            const dataAkreditasi = Object.entries(@json($akreditasi));
            const dataSekolah = @json($dataSekolah);

            // ---------- Tema (light / dark) ----------
            // Tema ditentukan oleh class "dark" pada <html> (diatur tombol ganti tema di layout)
            const gelap = () => document.documentElement.classList.contains('dark');

            const tema = () => ({
                teks: gelap() ? '#cbd5e1' : '#475569',
                grid: gelap() ? 'rgba(148,163,184,.15)' : 'rgba(100,116,139,.15)',
                border: gelap() ? '#1f2937' : '#ffffff',
                tipBg: gelap() ? '#0f172a' : '#1e293b',
            });

            const warna = {
                indigo: '#4f46e5',
                emerald: '#10b981',
                amber: '#f59e0b',
                sky: '#0ea5e9',
                rose: '#f43f5e',
                violet: '#8b5cf6',
                slate: '#94a3b8',
            };
            const cadangan = [warna.indigo, warna.amber, warna.emerald, warna.sky, warna.rose, warna.violet];

            const warnaStatus = {
                Negeri: warna.indigo,
                Swasta: warna.amber
            };
            const warnaAkreditasi = {
                A: warna.emerald,
                B: warna.sky,
                C: warna.amber,
                TT: warna.rose
            };

            // ---------- Util ----------
            const angka = (v) => Number(v) || 0;
            const potong = (s, n = 28) => (s = String(s), s.length > n ? s.slice(0, n - 1) + '…' : s);

            // Ganti canvas dengan pesan jika tidak ada data
            function kosong(id) {
                const el = document.getElementById(id);
                el.parentElement.innerHTML =
                    '<div class="flex h-full items-center justify-center text-sm text-gray-400">' +
                    '<i class="bi bi-bar-chart me-2"></i>Belum ada data</div>';
            }

            const instances = {};

            function buat(id, config) {
                if (instances[id]) instances[id].destroy(); // cegah "Canvas is already in use"
                instances[id] = new Chart(document.getElementById(id), config);
            }

            function gambar() {
                const t = tema();
                Chart.defaults.font.family = 'inherit';
                Chart.defaults.color = t.teks;
                Chart.defaults.borderColor = t.grid;

                const dasar = {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        tooltip: {
                            backgroundColor: t.tipBg,
                            padding: 10,
                            cornerRadius: 8,
                            boxPadding: 4
                        },
                    },
                };

                // 1. Status sekolah (doughnut)
                const itemStatus = dataStatus
                    .map(([k, v]) => [k || 'Belum diisi', angka(v)])
                    .filter(([, v]) => v > 0);
                const sumStatus = itemStatus.reduce((a, [, v]) => a + v, 0);

                if (document.getElementById('chartStatus')) {
                    if (sumStatus === 0) {
                        kosong('chartStatus');
                    } else {
                        buat('chartStatus', {
                            type: 'doughnut',
                            data: {
                                labels: itemStatus.map(([k, v]) => `${k} (${v})`),
                                datasets: [{
                                    data: itemStatus.map(([, v]) => v),
                                    backgroundColor: itemStatus.map(([k], i) => warnaStatus[k] ??
                                        cadangan[i % cadangan.length]),
                                    borderWidth: 0,
                                    spacing: itemStatus.length > 1 ? 3 : 0,
                                    borderRadius: itemStatus.length > 1 ? 6 : 0,
                                    hoverOffset: 6,
                                }],
                            },
                            options: {
                                ...dasar,
                                cutout: '68%',
                                layout: {
                                    padding: 8
                                },
                                plugins: {
                                    ...dasar.plugins,
                                    legend: {
                                        position: 'bottom',
                                        labels: {
                                            usePointStyle: true,
                                            pointStyle: 'circle',
                                            padding: 16,
                                            boxWidth: 8,
                                            boxHeight: 8
                                        },
                                    },
                                    tooltip: {
                                        ...dasar.plugins.tooltip,
                                        callbacks: {
                                            title: () => '',
                                            label: (c) => {
                                                const [nama, jml] = itemStatus[c.dataIndex];
                                                return ` ${nama}: ${jml} sekolah (${Math.round(jml / sumStatus * 100)}%)`;
                                            },
                                        },
                                    },
                                },
                            },
                            // Total di tengah donat
                            plugins: [{
                                id: 'totalTengah',
                                afterDraw(chart) {
                                    const {
                                        ctx,
                                        chartArea: {
                                            left,
                                            right,
                                            top,
                                            bottom
                                        }
                                    } = chart;
                                    const x = (left + right) / 2;
                                    const y = (top + bottom) / 2;
                                    ctx.save();
                                    ctx.textAlign = 'center';
                                    ctx.textBaseline = 'middle';
                                    ctx.fillStyle = gelap() ? '#f1f5f9' : '#1e293b';
                                    ctx.font = '700 28px ' + getComputedStyle(document.body).fontFamily;
                                    ctx.fillText(sumStatus, x, y - 8);
                                    ctx.fillStyle = t.teks;
                                    ctx.font = '400 12px ' + getComputedStyle(document.body).fontFamily;
                                    ctx.fillText('Sekolah', x, y + 14);
                                    ctx.restore();
                                },
                            }],
                        });
                    }
                }

                // 2. Akreditasi (bar vertikal)
                const sumAkr = dataAkreditasi.reduce((a, [, v]) => a + angka(v), 0);
                if (sumAkr === 0) {
                    if (document.getElementById('chartAkreditasi')) kosong('chartAkreditasi');
                } else if (document.getElementById('chartAkreditasi')) {
                    buat('chartAkreditasi', {
                        type: 'bar',
                        data: {
                            labels: dataAkreditasi.map(([k]) => k),
                            datasets: [{
                                label: 'Jumlah Sekolah',
                                data: dataAkreditasi.map(([, v]) => angka(v)),
                                backgroundColor: dataAkreditasi.map(([k], i) => warnaAkreditasi[k] ??
                                    cadangan[i % cadangan.length]),
                                borderRadius: 8,
                                borderSkipped: false,
                                maxBarThickness: 56,
                            }],
                        },
                        options: {
                            ...dasar,
                            plugins: {
                                ...dasar.plugins,
                                legend: {
                                    display: false
                                }
                            },
                            scales: {
                                x: {
                                    grid: {
                                        display: false
                                    }
                                },
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        precision: 0
                                    }
                                },
                            },
                        },
                    });
                }

                // 3. Guru & TU per sekolah (bar horizontal, bertumpuk)
                if (dataSekolah.length === 0) {
                    if (document.getElementById('chartPegawai')) kosong('chartPegawai');
                } else if (document.getElementById('chartPegawai')) {
                    buat('chartPegawai', {
                        type: 'bar',
                        data: {
                            labels: dataSekolah.map((s) => s.nama_sekolah),
                            datasets: [{
                                    label: 'Guru',
                                    data: dataSekolah.map((s) => angka(s.guru_count)),
                                    backgroundColor: warna.indigo,
                                    borderRadius: 6,
                                    maxBarThickness: 26
                                },
                                {
                                    label: 'TU',
                                    data: dataSekolah.map((s) => angka(s.tu_count)),
                                    backgroundColor: warna.emerald,
                                    borderRadius: 6,
                                    maxBarThickness: 26
                                },
                            ],
                        },
                        options: {
                            ...dasar,
                            indexAxis: 'y',
                            interaction: {
                                mode: 'index',
                                axis: 'y',
                                intersect: false
                            },
                            plugins: {
                                ...dasar.plugins,
                                legend: {
                                    position: 'bottom',
                                    labels: {
                                        usePointStyle: true,
                                        pointStyle: 'circle',
                                        padding: 16
                                    }
                                },
                            },
                            scales: {
                                x: {
                                    stacked: true,
                                    beginAtZero: true,
                                    ticks: {
                                        precision: 0
                                    }
                                },
                                y: {
                                    stacked: true,
                                    grid: {
                                        display: false
                                    },
                                    ticks: {
                                        callback(v) {
                                            return potong(this.getLabelForValue(v));
                                        }
                                    },
                                },
                            },
                        },
                    });
                }
            }

            gambar();

            // Gambar ulang saat class dark berubah (tombol ganti tema)
            new MutationObserver(gambar).observe(document.documentElement, {
                attributes: true,
                attributeFilter: ['class']
            });
        })();
    </script>
@endpush
