@extends('layouts.admin')

@section('title', 'Data Sekolah')

@php
    $q = trim(request('q', ''));
    $col = $sekolahs->getCollection();

    // Data grafik per sekolah (hanya halaman ini)
    $dataSekolah = $col
        ->map(
            fn($s) => [
                'nama' => $s->nama_sekolah,
                'total' => (int) $s->guru_count + (int) $s->tu_count,
            ],
        )
        ->values();
@endphp

@section('content')
    {{-- Judul halaman --}}
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="text-xl font-semibold text-gray-800 dark:text-gray-100">Data Sekolah</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">Daftar sekolah beserta jumlah guru, TU, dan siswa</p>
        </div>
        <a href="{{ route('admin.sekolah.create') }}"
            class="inline-flex items-center gap-1.5 rounded-lg bg-indigo-600 px-3.5 py-2 text-sm font-medium text-white transition hover:bg-indigo-700">
            <i class="bi bi-plus-lg"></i> Tambah Sekolah
        </a>
    </div>

    {{-- Kartu statistik --}}
    <div class="grid grid-cols-2 gap-4 lg:grid-cols-4">
        @foreach ([['Total Sekolah', $total['sekolah'], 'text-indigo-600 dark:text-indigo-300'], ['Total Siswa', $total['siswa'], 'text-emerald-600 dark:text-emerald-300'], ['Guru', $total['guru'], 'text-amber-600 dark:text-amber-300'], ['Tenaga Kependidikan (TU)', $total['tu'], 'text-sky-600 dark:text-sky-300']] as [$nama, $angka, $warna])
            <x-card>
                <p class="truncate text-xs text-gray-500 dark:text-gray-400">{{ $nama }}</p>
                <p class="text-2xl font-semibold {{ $warna }}">{{ $angka }}</p>
            </x-card>
        @endforeach
    </div>

    {{-- Grafik donat --}}
    <div class="grid grid-cols-1 gap-4 lg:grid-cols-3">
        <x-card>
            <x-slot:header>
                <span class="font-semibold">Status Sekolah</span>
            </x-slot:header>
            <div class="relative h-64"><canvas id="chartStatus"></canvas></div>
        </x-card>
        <x-card>
            <x-slot:header>
                <span class="font-semibold">Akreditasi Sekolah</span>
            </x-slot:header>
            <div class="relative h-64"><canvas id="chartAkreditasi"></canvas></div>
        </x-card>
        <x-card>
            <x-slot:header>
                <span class="font-semibold">Guru + TU per Sekolah <span class="text-xs font-normal text-gray-400">(halaman
                        ini)</span></span>
            </x-slot:header>
            <div class="relative h-64"><canvas id="chartPegawai"></canvas></div>
        </x-card>
    </div>

    {{-- List + pencarian --}}
    <x-card>
        <x-slot:header>
            <span class="font-semibold">List Sekolah</span>
        </x-slot:header>

        <form method="GET" action="{{ route('admin.sekolah.index') }}" id="formCari" class="mb-4">
            <div class="relative max-w-sm">
                <i class="bi bi-search pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                <input type="text" name="q" value="{{ $q }}" autocomplete="off"
                    placeholder="Cari nama sekolah, NSS, NPSN, atau kecamatan..."
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
                Menampilkan <span class="font-semibold text-indigo-600 dark:text-indigo-300">{{ $sekolahs->total() }}</span>
                sekolah
                @if ($q !== '')
                    untuk pencarian "<span class="font-medium">{{ $q }}</span>"
                @endif
            </p>

            <x-table striped hover bordered class="text-sm">
                <x-slot:head>
                    <tr
                        class="bg-indigo-50 text-center align-middle text-indigo-900 dark:bg-indigo-500/20 dark:text-indigo-100">
                        <x-table.heading rowspan="2" class="text-center align-middle">No</x-table.heading>
                        <x-table.heading colspan="2" class="text-center">Nomor</x-table.heading>
                        <x-table.heading rowspan="2" class="min-w-56 text-center align-middle">Nama
                            Sekolah</x-table.heading>
                        <x-table.heading rowspan="2" class="text-center align-middle">Jumlah Guru</x-table.heading>
                        <x-table.heading rowspan="2" class="text-center align-middle">Jumlah TU</x-table.heading>
                        <x-table.heading rowspan="2" class="text-center align-middle">Jumlah Siswa</x-table.heading>
                        <x-table.heading rowspan="2" class="text-center align-middle">Status</x-table.heading>
                        <x-table.heading rowspan="2" class="text-center align-middle">Akreditasi</x-table.heading>
                        <x-table.heading rowspan="2" class="min-w-64 text-center align-middle">Alamat</x-table.heading>
                        <x-table.heading rowspan="2" class="text-center align-middle">Kecamatan</x-table.heading>
                        <x-table.heading rowspan="2" class="min-w-28 text-center align-middle">Aksi</x-table.heading>
                    </tr>
                    <tr class="bg-indigo-50 text-center text-indigo-900 dark:bg-indigo-500/20 dark:text-indigo-100">
                        <x-table.heading class="text-center">NSS</x-table.heading>
                        <x-table.heading class="text-center">NPSN</x-table.heading>
                    </tr>
                </x-slot:head>

                {{-- Baris total (jumlah sekolah pada halaman ini) --}}
                @if ($sekolahs->count())
                    <x-table.row class="bg-indigo-50 font-semibold dark:bg-indigo-500/10">
                        <x-table.cell colspan="4" class="text-center">Total (halaman ini)</x-table.cell>
                        <x-table.cell
                            class="text-center text-indigo-700 dark:text-indigo-200">{{ $col->sum('guru_count') }}</x-table.cell>
                        <x-table.cell
                            class="text-center text-indigo-700 dark:text-indigo-200">{{ $col->sum('tu_count') }}</x-table.cell>
                        <x-table.cell
                            class="text-center text-indigo-700 dark:text-indigo-200">{{ $col->sum('siswas_count') }}</x-table.cell>
                        <x-table.cell colspan="5"></x-table.cell>
                    </x-table.row>
                @endif

                @forelse($sekolahs as $sekolah)
                    <x-table.row>
                        <x-table.cell class="text-center">{{ $sekolahs->firstItem() + $loop->index }}</x-table.cell>
                        <x-table.cell class="whitespace-nowrap">{{ $sekolah->nss }}</x-table.cell>
                        <x-table.cell class="whitespace-nowrap">{{ $sekolah->npsn }}</x-table.cell>
                        <x-table.cell
                            class="font-medium text-indigo-700 dark:text-indigo-300">{{ $sekolah->nama_sekolah }}</x-table.cell>
                        <x-table.cell class="text-center">{{ $sekolah->guru_count }}</x-table.cell>
                        <x-table.cell class="text-center">{{ $sekolah->tu_count }}</x-table.cell>
                        <x-table.cell class="text-center">{{ $sekolah->siswas_count }}</x-table.cell>
                        <x-table.cell class="text-center">
                            <x-badge :variant="$sekolah->status_sekolah === 'Negeri' ? 'primary' : 'warning'" pill>{{ $sekolah->status_sekolah }}</x-badge>
                        </x-table.cell>
                        <x-table.cell class="text-center">
                            <x-badge variant="success" pill>{{ $sekolah->akreditasi }}</x-badge>
                        </x-table.cell>
                        <x-table.cell class="max-w-64 truncate"
                            title="{{ $sekolah->alamat }}">{{ $sekolah->alamat }}</x-table.cell>
                        <x-table.cell>{{ $sekolah->kecamatan }}</x-table.cell>
                        <x-table.cell class="whitespace-nowrap text-center">
                            <div class="inline-flex items-center gap-1">
                                <a href="{{ route('admin.sekolah.show', $sekolah) }}" title="Detail"
                                    class="rounded-lg border border-gray-200 px-2 py-1 text-gray-500 hover:border-indigo-300 hover:bg-indigo-50 hover:text-indigo-600 dark:border-gray-700">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('admin.sekolah.edit', $sekolah) }}" title="Edit"
                                    class="rounded-lg border border-gray-200 px-2 py-1 text-gray-500 hover:border-indigo-300 hover:bg-indigo-50 hover:text-indigo-600 dark:border-gray-700">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                {{-- Hapus memakai confirm biasa (bukan modal) agar tetap berfungsi setelah tabel diganti pencarian --}}
                                <form action="{{ route('admin.sekolah.destroy', $sekolah) }}" method="POST"
                                    class="inline" onsubmit="return confirm(@js('Hapus ' . $sekolah->nama_sekolah . '?'))">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" title="Hapus"
                                        class="rounded-lg border border-gray-200 px-2 py-1 text-gray-500 hover:border-rose-300 hover:bg-rose-50 hover:text-rose-600 dark:border-gray-700">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </x-table.cell>
                    </x-table.row>
                @empty
                    <x-table.empty colspan="12" />
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

            // Status dan akreditasi dikirim controller sebagai object {label: jumlah}
            const status = Object.entries(@json($status)).map(([k, v]) => [k || 'Belum diisi', Number(
                v) || 0
            ]);
            const akreditasi = Object.entries(@json($akreditasi)).map(([k, v]) => [k || 'Belum diisi', Number(
                v) || 0]);
            const sekolah = @json($dataSekolah);

            // Warna awal
            const palet = ['#4f46e5', '#f59e0b', '#10b981', '#0ea5e9', '#f43f5e',
            '#8b5cf6']; // urutan sama dengan halaman Pegawai
            const warnaStatus = {
                Negeri: '#4f46e5',
                Swasta: '#f59e0b'
            };
            const warnaAkreditasi = {
                A: '#10b981',
                B: '#0ea5e9',
                C: '#f59e0b',
                TT: '#f43f5e'
            };
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

            // item = [[label, jumlah], ...]; warnaMap = warna khusus per label (opsional)
            function donat(id, item, judul, warnaMap = {}) {
                const el = document.getElementById(id);
                if (instances[id]) instances[id].destroy();
                item = item.filter(([, v]) => v > 0);
                if (item.length === 0) {
                    el.parentElement.innerHTML =
                        '<div class="flex h-full items-center justify-center text-sm text-gray-400"><i class="bi bi-pie-chart me-2"></i>Belum ada data</div>';
                    return;
                }
                instances[id] = new Chart(el, {
                    type: 'doughnut',
                    data: {
                        labels: item.map(([k]) => k),
                        datasets: [{
                            data: item.map(([, v]) => v),
                            backgroundColor: item.map(([k], i) => warnaMap[k] ?? palet[i % palet
                                .length]),
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
                    plugins: [angka(judul)],
                });
            }

            function gambar() {
                donat('chartStatus', status, 'Sekolah', warnaStatus);
                donat('chartAkreditasi', akreditasi, 'Sekolah', warnaAkreditasi);
                donat('chartPegawai', sekolah.map(s => [s.nama, s.total]), 'Pegawai');
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
