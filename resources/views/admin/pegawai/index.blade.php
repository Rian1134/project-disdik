@extends('layouts.admin')

@section('title', 'Data Pegawai')

@section('content')
{{-- ===== Grafik ===== --}}
<div class="grid grid-cols-1 gap-4 md:grid-cols-2">
    <x-card>
        <x-slot:header>
            <span class="font-semibold"><i class="bi bi-pie-chart-fill me-2 text-indigo-500"></i>Komposisi Pegawai (Guru / TU)</span>
        </x-slot:header>
        <div class="relative h-64"><canvas id="chartJabatan"></canvas></div>
    </x-card>
    <x-card>
        <x-slot:header>
            <span class="font-semibold"><i class="bi bi-bar-chart-fill me-2 text-emerald-500"></i>Pegawai per Status Kepegawaian</span>
        </x-slot:header>
        <div class="relative h-64"><canvas id="chartStatus"></canvas></div>
    </x-card>
</div>

<x-card>
    <x-slot:header>
        <span class="font-semibold"><i class="bi bi-buildings-fill me-2 text-amber-500"></i>Jumlah Pegawai per Sekolah (halaman ini)</span>
    </x-slot:header>
    <div class="relative" style="height: {{ max(256, $sekolahs->count() * 44 + 60) }}px"><canvas id="chartSekolah"></canvas></div>
</x-card>

<x-card>
    <x-slot:header>
        <div class="flex items-center justify-between gap-2">
            <span class="font-semibold"><i class="bi bi-person-badge-fill me-2 text-amber-500"></i>List Pegawai</span>
            <x-button href="{{ route('admin.pegawai.create') }}" size="sm">
                <i class="bi bi-plus-lg me-1"></i> Tambah
            </x-button>
        </div>
    </x-slot:header>

    <x-table striped hover bordered class="text-sm">
        <x-slot:head>
            <tr class="bg-indigo-50 text-indigo-900 dark:bg-indigo-500/20 dark:text-indigo-100">
                <x-table.heading rowspan="3" class="text-center align-middle">No</x-table.heading>
                <x-table.heading colspan="2" class="text-center align-middle">Nomor</x-table.heading>
                <x-table.heading rowspan="3" class="text-center align-middle min-w-56">Nama Sekolah</x-table.heading>
                <x-table.heading colspan="11" class="text-center align-middle">Jumlah Pegawai</x-table.heading>
            </tr>
            <tr class="bg-indigo-50 text-indigo-900 dark:bg-indigo-500/20 dark:text-indigo-100">
                <x-table.heading rowspan="2" class="text-center align-middle">Statistik Sekolah (NSS)</x-table.heading>
                <x-table.heading rowspan="2" class="text-center align-middle">Pokok Sekolah Nasional (NPSN)</x-table.heading>
                <x-table.heading colspan="5" class="bg-indigo-100 text-center align-middle dark:bg-indigo-500/30">Tenaga Pendidik / Guru</x-table.heading>
                <x-table.heading colspan="5" class="bg-amber-100 text-center align-middle dark:bg-amber-500/30">Tenaga Kependidikan / Tata Usaha</x-table.heading>
                <x-table.heading rowspan="2" class="text-center align-middle">Total</x-table.heading>
            </tr>
            <tr class="bg-indigo-50 text-indigo-900 dark:bg-indigo-500/20 dark:text-indigo-100">
                <x-table.heading class="text-center align-middle">PNS</x-table.heading>
                <x-table.heading class="text-center align-middle">PPPK</x-table.heading>
                <x-table.heading class="text-center align-middle">PPPK Paruh Waktu</x-table.heading>
                <x-table.heading class="text-center align-middle">Honorer</x-table.heading>
                <x-table.heading class="text-center align-middle">Jumlah</x-table.heading>
                <x-table.heading class="text-center align-middle">PNS</x-table.heading>
                <x-table.heading class="text-center align-middle">PPPK</x-table.heading>
                <x-table.heading class="text-center align-middle">PPPK Paruh Waktu</x-table.heading>
                <x-table.heading class="text-center align-middle">Honorer</x-table.heading>
                <x-table.heading class="text-center align-middle">Jumlah</x-table.heading>
            </tr>
        </x-slot:head>

        @forelse($sekolahs as $sekolah)
            <x-table.row>
                <x-table.cell class="text-center">{{ $sekolahs->firstItem() + $loop->index }}</x-table.cell>
                <x-table.cell class="whitespace-nowrap">{{ $sekolah->nss }}</x-table.cell>
                <x-table.cell class="whitespace-nowrap">{{ $sekolah->npsn }}</x-table.cell>
                <x-table.cell class="font-medium">
                    <a href="{{ route('admin.pegawai.sekolah', $sekolah->id) }}" class="text-indigo-700 hover:underline dark:text-indigo-300">{{ $sekolah->nama_sekolah }}</a>
                </x-table.cell>
                <x-table.cell class="text-center text-indigo-600 dark:text-indigo-300">{{ $sekolah->guru_pns }}</x-table.cell>
                <x-table.cell class="text-center text-indigo-600 dark:text-indigo-300">{{ $sekolah->guru_pppk }}</x-table.cell>
                <x-table.cell class="text-center text-indigo-600 dark:text-indigo-300">{{ $sekolah->guru_paruh }}</x-table.cell>
                <x-table.cell class="text-center text-indigo-600 dark:text-indigo-300">{{ $sekolah->guru_honorer }}</x-table.cell>
                <x-table.cell class="text-center font-semibold text-indigo-600 dark:text-indigo-300">{{ $sekolah->guru_pns + $sekolah->guru_pppk + $sekolah->guru_paruh + $sekolah->guru_honorer }}</x-table.cell>
                <x-table.cell class="text-center text-amber-600 dark:text-amber-300">{{ $sekolah->tu_pns }}</x-table.cell>
                <x-table.cell class="text-center text-amber-600 dark:text-amber-300">{{ $sekolah->tu_pppk }}</x-table.cell>
                <x-table.cell class="text-center text-amber-600 dark:text-amber-300">{{ $sekolah->tu_paruh }}</x-table.cell>
                <x-table.cell class="text-center text-amber-600 dark:text-amber-300">{{ $sekolah->tu_honorer }}</x-table.cell>
                <x-table.cell class="text-center font-semibold text-amber-600 dark:text-amber-300">{{ $sekolah->tu_pns + $sekolah->tu_pppk + $sekolah->tu_paruh + $sekolah->tu_honorer }}</x-table.cell>
                <x-table.cell class="text-center font-semibold text-emerald-600 dark:text-emerald-300">{{ $sekolah->guru_pns + $sekolah->guru_pppk + $sekolah->guru_paruh + $sekolah->guru_honorer + $sekolah->tu_pns + $sekolah->tu_pppk + $sekolah->tu_paruh + $sekolah->tu_honorer }}</x-table.cell>
            </x-table.row>
        @empty
            <x-table.empty colspan="15" />
        @endforelse
    </x-table>

    <x-pagination :paginator="$sekolahs" class="mt-4" />
</x-card>
@endsection

@push('scripts')
@php
    $col = $sekolahs->getCollection();
    $jml = fn ($kolom) => (int) $col->sum(fn ($x) => (int) $x->{$kolom});

    $dataStatus = [
        ['status' => 'PNS',              'guru' => $jml('guru_pns'),     'tu' => $jml('tu_pns')],
        ['status' => 'PPPK',             'guru' => $jml('guru_pppk'),    'tu' => $jml('tu_pppk')],
        ['status' => 'PPPK Paruh Waktu', 'guru' => $jml('guru_paruh'),   'tu' => $jml('tu_paruh')],
        ['status' => 'Honorer',          'guru' => $jml('guru_honorer'), 'tu' => $jml('tu_honorer')],
    ];

    $dataSekolah = $col->map(fn ($x) => [
        'nama' => $x->nama_sekolah,
        'guru' => (int) $x->guru_pns + (int) $x->guru_pppk + (int) $x->guru_paruh + (int) $x->guru_honorer,
        'tu'   => (int) $x->tu_pns + (int) $x->tu_pppk + (int) $x->tu_paruh + (int) $x->tu_honorer,
    ])->values();
@endphp
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
<script>
(function () {
    if (typeof Chart === 'undefined') {
        console.error('Chart.js gagal dimuat (cek koneksi / CDN).');
        return;
    }

    // ---------- Data dari server (hanya sekolah pada halaman ini) ----------
    const dataStatus  = @json($dataStatus);
    const dataSekolah = @json($dataSekolah);

    const totalGuru = dataStatus.reduce((a, d) => a + d.guru, 0);
    const totalTu   = dataStatus.reduce((a, d) => a + d.tu, 0);
    const total     = totalGuru + totalTu;

    // ---------- Tema ----------
    const gelap = () => document.documentElement.classList.contains('dark');
    const tema = () => ({
        teks:  gelap() ? '#cbd5e1' : '#475569',
        grid:  gelap() ? 'rgba(148,163,184,.15)' : 'rgba(100,116,139,.15)',
        tipBg: gelap() ? '#0f172a' : '#1e293b',
    });

    const WARNA_GURU = '#4f46e5'; // indigo
    const WARNA_TU   = '#f59e0b'; // amber

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
                tooltip: { backgroundColor: t.tipBg, padding: 10, cornerRadius: 8, boxPadding: 4 },
            },
        };
        const legenda = { position: 'bottom', labels: { usePointStyle: true, pointStyle: 'circle', padding: 16 } };

        // 1. Komposisi Guru / TU (doughnut) + total di tengah
        if (total === 0) {
            kosong('chartJabatan');
        } else {
            buat('chartJabatan', {
                type: 'doughnut',
                data: {
                    labels: [`Guru (${totalGuru})`, `TU (${totalTu})`],
                    datasets: [{
                        data: [totalGuru, totalTu],
                        backgroundColor: [WARNA_GURU, WARNA_TU],
                        borderWidth: 0,
                        spacing: 3,
                        borderRadius: 6,
                        hoverOffset: 6,
                    }],
                },
                options: {
                    ...dasar,
                    cutout: '68%',
                    layout: { padding: 8 },
                    plugins: {
                        ...dasar.plugins,
                        legend: legenda,
                        tooltip: {
                            ...dasar.plugins.tooltip,
                            callbacks: {
                                title: () => '',
                                label: (c) => ` ${c.parsed} pegawai (${Math.round(c.parsed / total * 100)}%)`,
                            },
                        },
                    },
                },
                plugins: [{
                    id: 'totalTengah',
                    afterDraw(chart) {
                        const { ctx, chartArea: { left, right, top, bottom } } = chart;
                        const x = (left + right) / 2, y = (top + bottom) / 2;
                        const font = getComputedStyle(document.body).fontFamily;
                        ctx.save();
                        ctx.textAlign = 'center';
                        ctx.textBaseline = 'middle';
                        ctx.fillStyle = gelap() ? '#f1f5f9' : '#1e293b';
                        ctx.font = '700 28px ' + font;
                        ctx.fillText(total, x, y - 8);
                        ctx.fillStyle = t.teks;
                        ctx.font = '400 12px ' + font;
                        ctx.fillText('Pegawai', x, y + 14);
                        ctx.restore();
                    },
                }],
            });
        }

        // 2. Per status kepegawaian (bar berkelompok Guru vs TU)
        if (total === 0) {
            kosong('chartStatus');
        } else {
            buat('chartStatus', {
                type: 'bar',
                data: {
                    labels: dataStatus.map((d) => d.status),
                    datasets: [
                        { label: 'Guru', data: dataStatus.map((d) => d.guru), backgroundColor: WARNA_GURU, borderRadius: 8, borderSkipped: false, maxBarThickness: 40 },
                        { label: 'TU',   data: dataStatus.map((d) => d.tu),   backgroundColor: WARNA_TU,   borderRadius: 8, borderSkipped: false, maxBarThickness: 40 },
                    ],
                },
                options: {
                    ...dasar,
                    interaction: { mode: 'index', intersect: false },
                    plugins: { ...dasar.plugins, legend: legenda },
                    scales: {
                        x: { grid: { display: false } },
                        y: { beginAtZero: true, ticks: { precision: 0 } },
                    },
                },
            });
        }

        // 3. Per sekolah (bar horizontal bertumpuk)
        if (dataSekolah.length === 0 || dataSekolah.every((x) => x.guru + x.tu === 0)) {
            kosong('chartSekolah');
        } else {
            buat('chartSekolah', {
                type: 'bar',
                data: {
                    labels: dataSekolah.map((x) => x.nama),
                    datasets: [
                        { label: 'Guru', data: dataSekolah.map((x) => x.guru), backgroundColor: WARNA_GURU, borderRadius: 6, maxBarThickness: 26 },
                        { label: 'TU',   data: dataSekolah.map((x) => x.tu),   backgroundColor: WARNA_TU,   borderRadius: 6, maxBarThickness: 26 },
                    ],
                },
                options: {
                    ...dasar,
                    indexAxis: 'y',
                    interaction: { mode: 'index', axis: 'y', intersect: false },
                    plugins: { ...dasar.plugins, legend: legenda },
                    scales: {
                        x: { stacked: true, beginAtZero: true, ticks: { precision: 0 } },
                        y: {
                            stacked: true,
                            grid: { display: false },
                            ticks: { callback(v) { return potong(this.getLabelForValue(v)); } },
                        },
                    },
                },
            });
        }
    }

    gambar();

    // Gambar ulang saat tema diganti (class "dark" pada <html> berubah)
    new MutationObserver(gambar).observe(document.documentElement, { attributes: true, attributeFilter: ['class'] });
})();
</script>
@endpush