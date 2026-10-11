@extends('layouts.admin')

@section('title', 'Data Pegawai')

@php
    $q = trim(request('q', ''));
    $kat = ['pns', 'pppk', 'paruh', 'honorer'];
    $col = $sekolahs->getCollection();
    $jml = fn($kolom) => (int) $col->sum(fn($x) => (int) $x->$kolom);

    // Baris total di bawah tabel (jumlah sekolah pada halaman ini)
    $guruKolom = collect($kat)->map(fn($k) => $jml("guru_$k"));
    $tuKolom = collect($kat)->map(fn($k) => $jml("tu_$k"));
    $barisTotal = $guruKolom->concat([$guruKolom->sum()])->concat($tuKolom)->concat([$tuKolom->sum(), $guruKolom->sum() + $tuKolom->sum()]);

    // Data grafik (hanya sekolah pada halaman ini)
    $grafik = [
        'jabatan' => [collect($kat)->sum(fn($k) => $jml("guru_$k")), collect($kat)->sum(fn($k) => $jml("tu_$k"))],
        'status' => collect($kat)->map(fn($k) => $jml("guru_$k") + $jml("tu_$k"))->all(),
        'sekolah' => $col->map(fn($x) => [
            'nama' => $x->nama_sekolah,
            'total' => collect($kat)->sum(fn($k) => (int) $x->{"guru_$k"} + (int) $x->{"tu_$k"}),
        ])->values(),
    ];
@endphp

@section('content')
    {{-- Judul halaman --}}
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="text-xl font-semibold text-gray-800 dark:text-gray-100">Data Pegawai</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">Rekap guru dan tenaga kependidikan per sekolah</p>
        </div>
        <a href="{{ route('admin.pegawai.create') }}"
            class="inline-flex items-center gap-1.5 rounded-lg bg-indigo-600 px-3.5 py-2 text-sm font-medium text-white transition hover:bg-indigo-700">
            <i class="bi bi-plus-lg"></i> Tambah Pegawai
        </a>
    </div>

    {{-- Grafik donat --}}
    <div class="grid grid-cols-1 gap-4 lg:grid-cols-3">
        <x-card>
            <x-slot:header>
                <span class="font-semibold">Guru / TU</span>
            </x-slot:header>
            <div class="relative h-64"><canvas id="chartJabatan"></canvas></div>
        </x-card>
        <x-card>
            <x-slot:header>
                <span class="font-semibold">Status Kepegawaian</span>
            </x-slot:header>
            <div class="relative h-64"><canvas id="chartStatus"></canvas></div>
        </x-card>
        <x-card>
            <x-slot:header>
                <span class="font-semibold">Pegawai per Sekolah <span class="text-xs font-normal text-gray-400">(halaman ini)</span></span>
            </x-slot:header>
            <div class="relative h-64"><canvas id="chartSekolah"></canvas></div>
        </x-card>
    </div>

    {{-- List + pencarian --}}
    <x-card>
        <x-slot:header>
            <span class="font-semibold">List Pegawai</span>
        </x-slot:header>

        <form method="GET" action="{{ route('admin.pegawai.index') }}" id="formCari" class="mb-4">
            <div class="relative max-w-sm">
                <i class="bi bi-search pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                <input type="text" name="q" value="{{ $q }}" autocomplete="off" placeholder="Cari nama sekolah, NSS, atau NPSN..."
                    class="w-full rounded-md border border-gray-300 bg-white py-2 pl-9 pr-9 text-sm text-gray-900 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100">
                <button type="button" id="hapusCari" title="Hapus pencarian"
                    class="absolute right-2 top-1/2 -translate-y-1/2 rounded p-1 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 {{ $q === '' ? 'hidden' : '' }}">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
        </form>

        {{-- Bagian ini diganti oleh script pencarian di layout --}}
        <div id="hasil" class="transition-opacity">
            <p class="mb-2 text-xs text-gray-500 dark:text-gray-400">
                Menampilkan <span class="font-semibold text-indigo-600 dark:text-indigo-300">{{ $sekolahs->total() }}</span> sekolah
                @if ($q !== '')
                    untuk pencarian "<span class="font-medium">{{ $q }}</span>"
                @endif
            </p>

            <x-table striped hover bordered class="text-sm">
                <x-slot:head>
                    <tr class="bg-indigo-50 text-indigo-900 dark:bg-indigo-500/20 dark:text-indigo-100">
                        <x-table.heading rowspan="3" class="text-center align-middle">No</x-table.heading>
                        <x-table.heading colspan="2" class="text-center align-middle">Nomor</x-table.heading>
                        <x-table.heading rowspan="3" class="min-w-56 text-center align-middle">Nama Sekolah</x-table.heading>
                        <x-table.heading colspan="11" class="text-center align-middle">Jumlah Pegawai</x-table.heading>
                    </tr>
                    <tr class="bg-indigo-50 text-indigo-900 dark:bg-indigo-500/20 dark:text-indigo-100">
                        <x-table.heading rowspan="2" class="text-center align-middle">Statistik Sekolah (NSS)</x-table.heading>
                        <x-table.heading rowspan="2" class="text-center align-middle">Pokok Sekolah Nasional (NPSN)</x-table.heading>
                        <x-table.heading colspan="5" class="bg-indigo-100 text-center align-middle dark:bg-indigo-500/30">Tenaga Pendidik / Guru</x-table.heading>
                        <x-table.heading colspan="5" class="bg-gray-100 text-center align-middle text-gray-700 dark:bg-gray-700 dark:text-gray-100">Tenaga Kependidikan / Tata Usaha</x-table.heading>
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

                @if ($sekolahs->count())
                    <x-table.row class="bg-indigo-50 font-semibold dark:bg-indigo-500/10">
                        <x-table.cell colspan="4" class="text-center">Total (halaman ini)</x-table.cell>
                        @foreach ($barisTotal as $angka)
                            <x-table.cell class="text-center text-indigo-700 dark:text-indigo-200">{{ $angka }}</x-table.cell>
                        @endforeach
                    </x-table.row>
                @endif

                @forelse($sekolahs as $sekolah)
                    @php
                        $g = $sekolah->guru_pns + $sekolah->guru_pppk + $sekolah->guru_paruh + $sekolah->guru_honorer;
                        $t = $sekolah->tu_pns + $sekolah->tu_pppk + $sekolah->tu_paruh + $sekolah->tu_honorer;
                    @endphp
                    <x-table.row>
                        <x-table.cell class="text-center">{{ $sekolahs->firstItem() + $loop->index }}</x-table.cell>
                        <x-table.cell class="whitespace-nowrap">{{ $sekolah->nss }}</x-table.cell>
                        <x-table.cell class="whitespace-nowrap">{{ $sekolah->npsn }}</x-table.cell>
                        <x-table.cell class="font-medium">
                            <a href="{{ route('admin.pegawai.sekolah', $sekolah->id) }}" class="text-indigo-700 hover:underline dark:text-indigo-300">{{ $sekolah->nama_sekolah }}</a>
                        </x-table.cell>
                        <x-table.cell class="text-center">{{ $sekolah->guru_pns }}</x-table.cell>
                        <x-table.cell class="text-center">{{ $sekolah->guru_pppk }}</x-table.cell>
                        <x-table.cell class="text-center">{{ $sekolah->guru_paruh }}</x-table.cell>
                        <x-table.cell class="text-center">{{ $sekolah->guru_honorer }}</x-table.cell>
                        <x-table.cell class="text-center font-semibold text-indigo-600 dark:text-indigo-300">{{ $g }}</x-table.cell>
                        <x-table.cell class="text-center">{{ $sekolah->tu_pns }}</x-table.cell>
                        <x-table.cell class="text-center">{{ $sekolah->tu_pppk }}</x-table.cell>
                        <x-table.cell class="text-center">{{ $sekolah->tu_paruh }}</x-table.cell>
                        <x-table.cell class="text-center">{{ $sekolah->tu_honorer }}</x-table.cell>
                        <x-table.cell class="text-center font-semibold text-indigo-600 dark:text-indigo-300">{{ $t }}</x-table.cell>
                        <x-table.cell class="text-center font-bold text-indigo-700 dark:text-indigo-200">{{ $g + $t }}</x-table.cell>
                    </x-table.row>
                @empty
                    <x-table.empty colspan="15" />
                @endforelse
            </x-table>

            <x-pagination :paginator="$sekolahs" class="mt-4" />
        </div>
    </x-card>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
    <script>
        (function() {
            if (typeof Chart === 'undefined') return;

            const grafik = @json($grafik);
            // Warna awal: indigo, amber (guru/TU), lalu sky, emerald, rose, violet
            const warna = ['#4f46e5', '#f59e0b', '#10b981', '#0ea5e9', '#f43f5e', '#8b5cf6'];
            const gelap = () => document.documentElement.classList.contains('dark');
            const instances = {};

            // Plugin: angka di tiap irisan + total di tengah donat
            const angka = (judul) => ({
                id: 'angka',
                afterDatasetsDraw(c) {
                    const ctx = c.ctx;
                    const data = c.data.datasets[0].data;
                    ctx.save();
                    ctx.textAlign = 'center';
                    ctx.textBaseline = 'middle';
                    ctx.fillStyle = '#fff';
                    ctx.font = '700 12px sans-serif';
                    c.getDatasetMeta(0).data.forEach((arc, i) => {
                        if (!data[i] || arc.circumference < 0.3) return; // irisan terlalu kecil: lewati
                        const p = arc.tooltipPosition();
                        ctx.fillText(data[i], p.x, p.y);
                    });
                    const a = c.chartArea;
                    const x = (a.left + a.right) / 2,
                        y = (a.top + a.bottom) / 2;
                    ctx.fillStyle = gelap() ? '#f1f5f9' : '#1e293b';
                    ctx.font = '700 26px sans-serif';
                    ctx.fillText(data.reduce((s, n) => s + n, 0), x, y - 7);
                    ctx.fillStyle = gelap() ? '#94a3b8' : '#64748b';
                    ctx.font = '400 11px sans-serif';
                    ctx.fillText(judul, x, y + 15);
                    ctx.restore();
                },
            });

            function donat(id, label, data) {
                const el = document.getElementById(id);
                if (instances[id]) instances[id].destroy();
                if (data.reduce((s, n) => s + n, 0) === 0) {
                    el.parentElement.innerHTML =
                        '<div class="flex h-full items-center justify-center text-sm text-gray-400"><i class="bi bi-pie-chart me-2"></i>Belum ada data</div>';
                    return;
                }
                instances[id] = new Chart(el, {
                    type: 'doughnut',
                    data: {
                        labels: label,
                        datasets: [{
                            data: data,
                            backgroundColor: data.map((_, i) => warna[i % warna.length]),
                            borderWidth: 0,
                            spacing: 2,
                            borderRadius: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '65%',
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    usePointStyle: true,
                                    pointStyle: 'circle',
                                    boxWidth: 8,
                                    padding: 12,
                                    color: gelap() ? '#cbd5e1' : '#475569'
                                }
                            },
                            tooltip: {
                                backgroundColor: gelap() ? '#0f172a' : '#1e293b',
                                cornerRadius: 8,
                                padding: 10
                            },
                        },
                    },
                    plugins: [angka('Pegawai')],
                });
            }

            function gambar() {
                donat('chartJabatan', ['Guru', 'TU'], grafik.jabatan);
                donat('chartStatus', ['PNS', 'PPPK', 'PPPK Paruh Waktu', 'Honorer'], grafik.status);
                donat('chartSekolah', grafik.sekolah.map(s => s.nama), grafik.sekolah.map(s => s.total));
            }

            gambar();
            // Gambar ulang saat tema diganti
            new MutationObserver(gambar).observe(document.documentElement, {
                attributes: true,
                attributeFilter: ['class']
            });
        })();
    </script>
@endpush