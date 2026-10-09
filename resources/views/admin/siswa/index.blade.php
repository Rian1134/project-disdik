@extends('layouts.admin')

@section('title', 'Data Siswa')

@section('content')
    {{-- ===== Grafik ===== --}}
    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
        <x-card>
            <x-slot:header>
                <span class="font-semibold"><i class="bi bi-gender-ambiguous me-2 text-indigo-500"></i>Komposisi Siswa
                    (L/P)</span>
            </x-slot:header>
            <div class="relative h-64"><canvas id="chartGender"></canvas></div>
        </x-card>
        <x-card>
            <x-slot:header>
                <span class="font-semibold"><i class="bi bi-bar-chart-fill me-2 text-emerald-500"></i>Siswa per Kelas</span>
            </x-slot:header>
            <div class="relative h-64"><canvas id="chartKelas"></canvas></div>
        </x-card>
    </div>

    <x-card>
        <x-slot:header>
            <span class="font-semibold"><i class="bi bi-buildings-fill me-2 text-amber-500"></i>Jumlah Siswa per Sekolah
                (halaman ini)</span>
        </x-slot:header>
        <div class="relative" style="height: {{ max(256, $sekolahs->count() * 44 + 60) }}px"><canvas
                id="chartSekolah"></canvas></div>
    </x-card>

    <x-card>
        <x-slot:header>
            <span class="font-semibold"><i class="bi bi-people-fill me-2 text-emerald-500"></i>List Siswa</span>
        </x-slot:header>

        <x-table striped hover bordered class="text-sm">
            <x-slot:head>
                <tr class="bg-indigo-50 text-indigo-900 dark:bg-indigo-500/20 dark:text-indigo-100">
                    <x-table.heading rowspan="3" class="text-center align-middle">No</x-table.heading>
                    <x-table.heading colspan="2" class="text-center align-middle">Nomor</x-table.heading>
                    <x-table.heading rowspan="3" class="min-w-56 text-center align-middle">Nama Sekolah</x-table.heading>
                    <x-table.heading colspan="16" class="text-center align-middle">Jumlah Siswa</x-table.heading>
                    <x-table.heading rowspan="3" class="text-center align-middle">Aksi</x-table.heading>
                </tr>
                <tr class="bg-indigo-50 text-indigo-900 dark:bg-indigo-500/20 dark:text-indigo-100">
                    <x-table.heading rowspan="2" class="text-center align-middle">Statistik Sekolah
                        (NSS)</x-table.heading>
                    <x-table.heading rowspan="2" class="text-center align-middle">Pokok Sekolah Nasional
                        (NPSN)</x-table.heading>
                    <x-table.heading colspan="4" class="text-center align-middle">Kelas VII</x-table.heading>
                    <x-table.heading colspan="4" class="text-center align-middle">Kelas VIII</x-table.heading>
                    <x-table.heading colspan="4" class="text-center align-middle">Kelas IX</x-table.heading>
                    <x-table.heading colspan="4" class="text-center align-middle">Jumlah Seluruh</x-table.heading>
                </tr>
                <tr class="bg-indigo-50 text-indigo-900 dark:bg-indigo-500/20 dark:text-indigo-100">
                    <x-table.heading class="text-center align-middle">Rombel</x-table.heading>
                    <x-table.heading class="text-center align-middle">L</x-table.heading>
                    <x-table.heading class="text-center align-middle">P</x-table.heading>
                    <x-table.heading class="text-center align-middle">Jlh</x-table.heading>
                    <x-table.heading class="text-center align-middle">Rombel</x-table.heading>
                    <x-table.heading class="text-center align-middle">L</x-table.heading>
                    <x-table.heading class="text-center align-middle">P</x-table.heading>
                    <x-table.heading class="text-center align-middle">Jlh</x-table.heading>
                    <x-table.heading class="text-center align-middle">Rombel</x-table.heading>
                    <x-table.heading class="text-center align-middle">L</x-table.heading>
                    <x-table.heading class="text-center align-middle">P</x-table.heading>
                    <x-table.heading class="text-center align-middle">Jlh</x-table.heading>
                    <x-table.heading class="text-center align-middle">Rombel</x-table.heading>
                    <x-table.heading class="text-center align-middle">L</x-table.heading>
                    <x-table.heading class="text-center align-middle">P</x-table.heading>
                    <x-table.heading class="text-center align-middle">Siswa</x-table.heading>
                </tr>
            </x-slot:head>

            @forelse($sekolahs as $sekolah)
                <x-table.row>
                    <x-table.cell class="text-center">{{ $sekolahs->firstItem() + $loop->index }}</x-table.cell>
                    <x-table.cell class="whitespace-nowrap">{{ $sekolah->nss }}</x-table.cell>
                    <x-table.cell class="whitespace-nowrap">{{ $sekolah->npsn }}</x-table.cell>
                    <x-table.cell
                        class="font-medium text-indigo-700 dark:text-indigo-300">{{ $sekolah->nama_sekolah }}</x-table.cell>
                    <x-table.cell class="text-center">{{ $sekolah->vii_rombel }}</x-table.cell>
                    <x-table.cell class="text-center text-sky-600 dark:text-sky-300">{{ $sekolah->vii_l }}</x-table.cell>
                    <x-table.cell class="text-center text-rose-500 dark:text-rose-300">{{ $sekolah->vii_p }}</x-table.cell>
                    <x-table.cell
                        class="text-center font-semibold text-emerald-600 dark:text-emerald-300">{{ $sekolah->vii_l + $sekolah->vii_p }}</x-table.cell>
                    <x-table.cell class="text-center">{{ $sekolah->viii_rombel }}</x-table.cell>
                    <x-table.cell class="text-center text-sky-600 dark:text-sky-300">{{ $sekolah->viii_l }}</x-table.cell>
                    <x-table.cell
                        class="text-center text-rose-500 dark:text-rose-300">{{ $sekolah->viii_p }}</x-table.cell>
                    <x-table.cell
                        class="text-center font-semibold text-emerald-600 dark:text-emerald-300">{{ $sekolah->viii_l + $sekolah->viii_p }}</x-table.cell>
                    <x-table.cell class="text-center">{{ $sekolah->ix_rombel }}</x-table.cell>
                    <x-table.cell class="text-center text-sky-600 dark:text-sky-300">{{ $sekolah->ix_l }}</x-table.cell>
                    <x-table.cell class="text-center text-rose-500 dark:text-rose-300">{{ $sekolah->ix_p }}</x-table.cell>
                    <x-table.cell
                        class="text-center font-semibold text-emerald-600 dark:text-emerald-300">{{ $sekolah->ix_l + $sekolah->ix_p }}</x-table.cell>
                    <x-table.cell class="text-center">{{ $sekolah->total_rombel }}</x-table.cell>
                    <x-table.cell class="text-center text-sky-600 dark:text-sky-300">{{ $sekolah->total_l }}</x-table.cell>
                    <x-table.cell
                        class="text-center text-rose-500 dark:text-rose-300">{{ $sekolah->total_p }}</x-table.cell>
                    <x-table.cell
                        class="text-center font-semibold text-emerald-600 dark:text-emerald-300">{{ $sekolah->total_l + $sekolah->total_p }}</x-table.cell>
                    <x-table.cell class="text-center whitespace-nowrap">
                        <a href="{{ route('admin.siswa.sekolah', $sekolah->id) }}"
                            class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-1.5 text-xs font-medium text-white shadow-sm transition hover:bg-indigo-700">
                            <i class="bi bi-people-fill me-1"></i> Lihat Siswa
                        </a>
                    </x-table.cell>
                </x-table.row>
            @empty
                <x-table.empty colspan="21" />
            @endforelse
        </x-table>

        <x-pagination :paginator="$sekolahs" class="mt-4" />
    </x-card>
@endsection

@push('scripts')
    @php
        $col = $sekolahs->getCollection();
        $jumlah = fn($kolom) => (int) $col->sum(fn($x) => (int) $x->{$kolom});

        $dataKelas = [
            ['kelas' => 'VII', 'l' => $jumlah('vii_l'), 'p' => $jumlah('vii_p')],
            ['kelas' => 'VIII', 'l' => $jumlah('viii_l'), 'p' => $jumlah('viii_p')],
            ['kelas' => 'IX', 'l' => $jumlah('ix_l'), 'p' => $jumlah('ix_p')],
        ];

        $dataSekolah = $col
            ->map(
                fn($x) => [
                    'nama' => $x->nama_sekolah,
                    'l' => (int) $x->total_l,
                    'p' => (int) $x->total_p,
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

            // ---------- Data dari server (hanya sekolah pada halaman ini) ----------
            const dataKelas = @json($dataKelas);
            const dataSekolah = @json($dataSekolah);

            const totalL = dataKelas.reduce((a, k) => a + k.l, 0);
            const totalP = dataKelas.reduce((a, k) => a + k.p, 0);
            const total = totalL + totalP;

            // ---------- Tema ----------
            const gelap = () => document.documentElement.classList.contains('dark');
            const tema = () => ({
                teks: gelap() ? '#cbd5e1' : '#475569',
                grid: gelap() ? 'rgba(148,163,184,.15)' : 'rgba(100,116,139,.15)',
                tipBg: gelap() ? '#0f172a' : '#1e293b',
            });

            const WARNA_L = '#0ea5e9'; // sky   - laki-laki
            const WARNA_P = '#f43f5e'; // rose  - perempuan

            const potong = (s, n = 28) => (s = String(s), s.length > n ? s.slice(0, n - 1) + '…' : s);

            function kosong(id) {
                const el = document.getElementById(id);
                if (!el) return;
                el.parentElement.innerHTML =
                    '<div class="flex h-full items-center justify-center text-sm text-gray-400">' +
                    '<i class="bi bi-bar-chart me-2"></i>Belum ada data</div>';
            }

            const instances = {};

            function buat(id, config) {
                const el = document.getElementById(id);
                if (!el) return;
                if (instances[id]) instances[id].destroy();
                instances[id] = new Chart(el, config);
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
                const legenda = {
                    position: 'bottom',
                    labels: {
                        usePointStyle: true,
                        pointStyle: 'circle',
                        padding: 16
                    }
                };

                // 1. Komposisi L/P (doughnut) + total di tengah
                if (total === 0) {
                    kosong('chartGender');
                } else {
                    buat('chartGender', {
                        type: 'doughnut',
                        data: {
                            labels: [`Laki-laki (${totalL})`, `Perempuan (${totalP})`],
                            datasets: [{
                                data: [totalL, totalP],
                                backgroundColor: [WARNA_L, WARNA_P],
                                borderWidth: 0,
                                spacing: 3,
                                borderRadius: 6,
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
                                legend: legenda,
                                tooltip: {
                                    ...dasar.plugins.tooltip,
                                    callbacks: {
                                        title: () => '',
                                        label: (c) =>
                                            ` ${c.parsed} siswa (${Math.round(c.parsed / total * 100)}%)`,
                                    },
                                },
                            },
                        },
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
                                const x = (left + right) / 2,
                                    y = (top + bottom) / 2;
                                const font = getComputedStyle(document.body).fontFamily;
                                ctx.save();
                                ctx.textAlign = 'center';
                                ctx.textBaseline = 'middle';
                                ctx.fillStyle = gelap() ? '#f1f5f9' : '#1e293b';
                                ctx.font = '700 28px ' + font;
                                ctx.fillText(total, x, y - 8);
                                ctx.fillStyle = t.teks;
                                ctx.font = '400 12px ' + font;
                                ctx.fillText('Siswa', x, y + 14);
                                ctx.restore();
                            },
                        }],
                    });
                }

                // 2. Siswa per kelas (bar berkelompok L vs P)
                if (total === 0) {
                    kosong('chartKelas');
                } else {
                    buat('chartKelas', {
                        type: 'bar',
                        data: {
                            labels: dataKelas.map((k) => 'Kelas ' + k.kelas),
                            datasets: [{
                                    label: 'Laki-laki',
                                    data: dataKelas.map((k) => k.l),
                                    backgroundColor: WARNA_L,
                                    borderRadius: 8,
                                    borderSkipped: false,
                                    maxBarThickness: 40
                                },
                                {
                                    label: 'Perempuan',
                                    data: dataKelas.map((k) => k.p),
                                    backgroundColor: WARNA_P,
                                    borderRadius: 8,
                                    borderSkipped: false,
                                    maxBarThickness: 40
                                },
                            ],
                        },
                        options: {
                            ...dasar,
                            interaction: {
                                mode: 'index',
                                intersect: false
                            },
                            plugins: {
                                ...dasar.plugins,
                                legend: legenda
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

                // 3. Siswa per sekolah (bar horizontal bertumpuk)
                if (dataSekolah.length === 0 || dataSekolah.every((x) => x.l + x.p === 0)) {
                    kosong('chartSekolah');
                } else {
                    buat('chartSekolah', {
                        type: 'bar',
                        data: {
                            labels: dataSekolah.map((x) => x.nama),
                            datasets: [{
                                    label: 'Laki-laki',
                                    data: dataSekolah.map((x) => x.l),
                                    backgroundColor: WARNA_L,
                                    borderRadius: 6,
                                    maxBarThickness: 26
                                },
                                {
                                    label: 'Perempuan',
                                    data: dataSekolah.map((x) => x.p),
                                    backgroundColor: WARNA_P,
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
                                legend: legenda
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

            // Gambar ulang saat tema diganti (class "dark" pada <html> berubah)
            new MutationObserver(gambar).observe(document.documentElement, {
                attributes: true,
                attributeFilter: ['class']
            });
        })();
    </script>
@endpush
