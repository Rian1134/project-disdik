@extends('layouts.home')

@section('title', 'SIMANDIK - Sistem Informasi Manajemen Peserta Didik & Pendidik')

@section('content')

    {{-- Hero --}}
    <section id="beranda" class="relative isolate flex min-h-[75svh] items-center overflow-hidden sm:min-h-[80vh]">
        {{-- Foto latar: overlay dibuat lebih tipis supaya foto gedung tetap terlihat --}}
        <img src="{{ asset('assets/img/foto-disdik.webp') }}" alt="Gedung Dinas Pendidikan dan Kebudayaan Kabupaten Lahat"
            class="absolute inset-0 -z-20 h-full w-full object-cover object-[center_40%]">
        <div class="absolute inset-0 -z-10 bg-linear-to-b from-blue-950/70 via-blue-900/50 to-blue-950/80"></div>

        <div class="mx-auto w-full max-w-4xl px-4 pb-28 pt-10 text-center text-white sm:pb-36 sm:pt-20 lg:pt-28">
            {{-- Logo --}}
            <div
                class="mx-auto flex h-24 w-24 items-center justify-center rounded-full bg-white shadow-xl ring-4 ring-white/40 sm:h-28 sm:w-28">
                <img src="{{ asset('assets/img/icon-web.webp') }}" alt="Logo Tut Wuri Handayani" width="80" height="80"
                    class="h-16 w-16 object-contain sm:h-20 sm:w-20">
            </div>

            <span
                class="mt-6 inline-flex max-w-full items-center gap-2 rounded-2xl bg-white/20 px-3 py-1.5 text-center text-xs font-semibold leading-snug backdrop-blur sm:rounded-full sm:text-sm">
                <i class="bi bi-building shrink-0"></i>
                <span>Dinas Pendidikan dan Kebudayaan Kabupaten Lahat</span>
            </span>

            <h1 class="mt-5 text-4xl font-extrabold tracking-tight drop-shadow-lg sm:text-5xl lg:text-6xl">
                SIMANDIK
            </h1>
            <p class="mt-3 text-lg font-semibold drop-shadow sm:text-xl lg:text-2xl">
                Sistem Informasi Manajemen Peserta Didik &amp; Pendidik
            </p>
            <p class="mx-auto mt-4 max-w-2xl text-sm text-blue-50 drop-shadow sm:text-base lg:text-lg">
                Kelola data sekolah, siswa, dan pegawai dalam satu aplikasi yang sederhana dan terintegrasi.
            </p>

            <div class="mt-8 flex flex-col items-stretch justify-center gap-3 sm:flex-row sm:items-center">
                <x-button href="{{ route('login') }}" size="lg" class="w-full sm:w-auto">Masuk ke Aplikasi</x-button>
                <x-button href="#grafik" variant="light" size="lg" class="w-full sm:w-auto">Lihat
                    Grafik</x-button>
            </div>
        </div>
    </section>

    {{-- Statistik: kartu menimpa bagian bawah hero --}}
    <section id="statistik" class="relative z-10 mx-auto -mt-20 max-w-6xl scroll-mt-4 px-4 pb-14 sm:-mt-24 sm:pb-20">
        @php
            $items = [
                [
                    'label' => 'Siswa',
                    'value' => $stats['siswa'],
                    'icon' => 'bi-mortarboard-fill',
                    'color' => 'bg-blue-100 text-blue-600 dark:bg-blue-900/40 dark:text-blue-300',
                ],
                [
                    'label' => 'Tenaga Pendidik',
                    'value' => $stats['pendidik'],
                    'icon' => 'bi-person-workspace',
                    'color' => 'bg-emerald-100 text-emerald-600 dark:bg-emerald-900/40 dark:text-emerald-300',
                ],
                [
                    'label' => 'Tenaga Kependidikan',
                    'value' => $stats['kependidikan'],
                    'icon' => 'bi-person-badge-fill',
                    'color' => 'bg-amber-100 text-amber-600 dark:bg-amber-900/40 dark:text-amber-300',
                ],
                [
                    'label' => 'Sekolah',
                    'value' => $stats['sekolah'],
                    'icon' => 'bi-building-fill',
                    'color' => 'bg-violet-100 text-violet-600 dark:bg-violet-900/40 dark:text-violet-300',
                ],
            ];
        @endphp

        <div class="grid grid-cols-2 gap-3 sm:gap-6 lg:grid-cols-4">
            @foreach ($items as $item)
                <x-card class="h-full shadow-lg">
                    <div class="flex flex-col items-center py-2 text-center sm:py-4">
                        <span
                            class="flex h-12 w-12 items-center justify-center rounded-full text-2xl sm:h-16 sm:w-16 sm:text-3xl {{ $item['color'] }}">
                            <i class="bi {{ $item['icon'] }}"></i>
                        </span>
                        <div class="mt-3 text-2xl font-bold sm:mt-4 sm:text-4xl">
                            {{ number_format($item['value'], 0, ',', '.') }}
                        </div>
                        <div
                            class="mt-1 wrap-break-word text-[11px] font-medium uppercase leading-tight tracking-wide text-gray-500 dark:text-gray-400 sm:text-sm">
                            {{ $item['label'] }}
                        </div>
                    </div>
                </x-card>
            @endforeach
        </div>
    </section>

    {{-- Grafik ringkasan --}}
    <section id="grafik" class="scroll-mt-20 bg-white py-14 dark:bg-gray-800 sm:py-20">
        @php
            // [id canvas, judul, ikon, data, satuan, warna khusus per label, jenis grafik, ubin ikon]
            $grafiks = [
                [
                    'grafikKelas',
                    'Rasio Kelas Siswa',
                    'bi-mortarboard-fill',
                    $grafikKelas,
                    'siswa',
                    [],
                    'batang',
                    'bg-blue-100 text-blue-600 dark:bg-blue-900/40 dark:text-blue-300',
                ],
                [
                    'grafikPendidik',
                    'Rasio Status Tenaga Pendidik',
                    'bi-person-workspace',
                    $grafikPendidik,
                    'pendidik',
                    [],
                    'donat',
                    'bg-emerald-100 text-emerald-600 dark:bg-emerald-900/40 dark:text-emerald-300',
                ],
                [
                    'grafikKependidikan',
                    'Rasio Status Tenaga Kependidikan',
                    'bi-person-badge-fill',
                    $grafikKependidikan,
                    'kependidikan',
                    [],
                    'mendatar',
                    'bg-amber-100 text-amber-600 dark:bg-amber-900/40 dark:text-amber-300',
                ],
                [
                    'grafikSekolah',
                    'Rasio Sekolah Negeri dan Swasta',
                    'bi-building-fill',
                    $grafikSekolah,
                    'sekolah',
                    ['Negeri' => '#2563eb', 'Swasta' => '#f59e0b'],
                    'setengah',
                    'bg-violet-100 text-violet-600 dark:bg-violet-900/40 dark:text-violet-300',
                ],
            ];
        @endphp

        <div class="mx-auto max-w-6xl px-4">
            <div class="mb-8 text-center sm:mb-12">
                <h2 class="text-2xl font-bold sm:text-3xl">Ringkasan Data</h2>
                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400 sm:text-base">
                    Komposisi siswa, tenaga pendidik, tenaga kependidikan, dan sekolah.
                </p>
            </div>

            <div class="grid grid-cols-1 gap-4 sm:gap-6 md:grid-cols-2">
                @foreach ($grafiks as [$id, $judul, $ikon, $data, $satuan, $warna, $jenis, $ubin])
                    <x-card class="shadow-md">
                        <x-slot:header>
                            <div class="flex items-center justify-between gap-3">
                                <span class="flex min-w-0 items-center gap-2.5 font-semibold">
                                    <span
                                        class="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-lg {{ $ubin }}">
                                        <i class="bi {{ $ikon }}"></i>
                                    </span>
                                    <span class="truncate">{{ $judul }}</span>
                                </span>
                                <span
                                    class="shrink-0 rounded-full bg-gray-100 px-2.5 py-1 text-xs font-semibold text-gray-600 dark:bg-gray-700 dark:text-gray-200">
                                    {{ number_format($data->sum(), 0, ',', '.') }} {{ $satuan }}
                                </span>
                            </div>
                        </x-slot:header>

                        @if ($data->isEmpty())
                            <p class="py-16 text-center text-sm text-gray-500 dark:text-gray-400">Belum ada data.</p>
                        @else
                            <div class="h-64 sm:h-72">
                                <canvas id="{{ $id }}" aria-label="{{ $judul }}" role="img"></canvas>
                            </div>
                        @endif
                    </x-card>
                @endforeach
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <script>
        const gelap = () => document.documentElement.classList.contains('dark');
        Chart.defaults.color = gelap() ? '#d1d5db' : '#4b5563';
        Chart.defaults.font.family = 'inherit';

        const palet = ['#2563eb', '#10b981', '#f59e0b', '#8b5cf6', '#f43f5e', '#14b8a6', '#ec4899', '#64748b'];
        const jumlah = (data) => data.reduce((a, b) => a + b, 0);
        const persen = (n, total) => total ? Math.round(n / total * 100) : 0;

        // Warna per label: warna khusus jika ada, selain itu palet
        const warnaLabel = (data, khusus) => Object.keys(data).map((k, i) => khusus[k] ?? palet[i % palet.length]);

        // Tooltip seragam: "Label: 12 siswa (40%)"
        const tooltip = (satuan) => ({
            callbacks: {
                label: (c) => ` ${c.label}: ${c.raw} ${satuan} (${persen(c.raw, jumlah(c.dataset.data))}%)`,
            },
        });

        // Gradasi warna pada batang
        const gradasi = (k, warna, mendatar) => {
            const a = k.chart.chartArea;
            if (!a) return warna;
            const g = mendatar ? k.chart.ctx.createLinearGradient(a.left, 0, a.right, 0) :
                k.chart.ctx.createLinearGradient(0, a.bottom, 0, a.top);
            g.addColorStop(0, warna + '80');
            g.addColorStop(1, warna);
            return g;
        };

        // Plugin: nilai & persen di ujung batang
        const labelBatang = {
            id: 'labelBatang',
            afterDatasetsDraw(chart) {
                const ctx = chart.ctx;
                const data = chart.data.datasets[0].data;
                const total = jumlah(data);
                const mendatar = chart.options.indexAxis === 'y';

                ctx.save();
                ctx.fillStyle = gelap() ? '#e2e8f0' : '#334155';
                ctx.font = '600 12px sans-serif';
                chart.getDatasetMeta(0).data.forEach((batang, i) => {
                    const teks = `${data[i]} (${persen(data[i], total)}%)`;
                    if (mendatar) {
                        ctx.textAlign = 'left';
                        ctx.textBaseline = 'middle';
                        ctx.fillText(teks, batang.x + 8, batang.y);
                    } else {
                        ctx.textAlign = 'center';
                        ctx.textBaseline = 'bottom';
                        ctx.fillText(teks, batang.x, batang.y - 6);
                    }
                });
                ctx.restore();
            },
        };

        // Plugin: angka di irisan + total di tengah donat
        const pusat = (judul, setengah) => ({
            id: 'pusat',
            afterDatasetsDraw(chart) {
                const pusatArc = chart.getDatasetMeta(0).data[0];
                if (!pusatArc) return;
                const ctx = chart.ctx;
                const data = chart.data.datasets[0].data;

                ctx.save();
                ctx.textAlign = 'center';
                ctx.textBaseline = 'middle';

                ctx.fillStyle = '#fff';
                ctx.font = '700 12px sans-serif';
                chart.getDatasetMeta(0).data.forEach((irisan, i) => {
                    if (!data[i] || irisan.circumference < 0.3) return;
                    const p = irisan.tooltipPosition();
                    ctx.fillText(data[i], p.x, p.y);
                });

                const y = pusatArc.y + (setengah ? -26 : -7);
                ctx.fillStyle = gelap() ? '#f1f5f9' : '#1e293b';
                ctx.font = '700 26px sans-serif';
                ctx.fillText(jumlah(data), pusatArc.x, y);
                ctx.fillStyle = gelap() ? '#94a3b8' : '#64748b';
                ctx.font = '400 11px sans-serif';
                ctx.fillText(judul, pusatArc.x, y + 22);
                ctx.restore();
            },
        });

        // Batang tegak / mendatar dengan sudut membulat dan gradasi
        const batang = (id, data, satuan, khusus, mendatar = false) => {
            const warna = warnaLabel(data, khusus);
            const sumbuNilai = {
                beginAtZero: true,
                ticks: {
                    precision: 0
                },
                grid: {
                    color: 'rgba(148,163,184,.2)'
                },
                border: {
                    display: false
                },
            };
            const sumbuKategori = {
                grid: {
                    display: false
                },
                border: {
                    display: false
                }
            };

            new Chart(document.getElementById(id), {
                type: 'bar',
                data: {
                    labels: Object.keys(data),
                    datasets: [{
                        data: Object.values(data),
                        backgroundColor: (k) => gradasi(k, warna[k.dataIndex], mendatar),
                        borderRadius: 10,
                        borderSkipped: false,
                        maxBarThickness: mendatar ? 28 : 52,
                    }],
                },
                options: {
                    indexAxis: mendatar ? 'y' : 'x',
                    maintainAspectRatio: false,
                    layout: {
                        padding: mendatar ? {
                            right: 70
                        } : {
                            top: 24
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: tooltip(satuan)
                    },
                    scales: mendatar ? {
                        x: sumbuNilai,
                        y: sumbuKategori
                    } : {
                        x: sumbuKategori,
                        y: sumbuNilai
                    },
                },
                plugins: [labelBatang],
            });
        };
        const mendatar = (id, data, satuan, khusus) => batang(id, data, satuan, khusus, true);

        // Donat penuh atau setengah lingkaran, irisan membulat dengan jarak antar irisan
        const donat = (id, data, satuan, khusus, setengah = false) => {
            const warna = warnaLabel(data, khusus);

            new Chart(document.getElementById(id), {
                type: 'doughnut',
                data: {
                    labels: Object.keys(data),
                    datasets: [{
                        data: Object.values(data),
                        backgroundColor: warna,
                        borderWidth: 0,
                        borderRadius: 10,
                        spacing: 4,
                        hoverOffset: 6,
                    }],
                },
                options: {
                    maintainAspectRatio: false,
                    cutout: setengah ? '68%' : '66%',
                    rotation: setengah ? -90 : 0,
                    circumference: setengah ? 180 : 360,
                    plugins: {
                        tooltip: tooltip(satuan),
                        legend: {
                            position: 'bottom',
                            labels: {
                                usePointStyle: true,
                                pointStyle: 'circle',
                                padding: 16,
                                generateLabels(chart) {
                                    const nilai = chart.data.datasets[0].data;
                                    const total = jumlah(nilai);
                                    return chart.data.labels.map((l, i) => ({
                                        text: `${l} · ${persen(nilai[i], total)}%`,
                                        fillStyle: warna[i],
                                        strokeStyle: warna[i],
                                        pointStyle: 'circle',
                                        hidden: !chart.getDataVisibility(i),
                                        index: i,
                                    }));
                                },
                            },
                        },
                    },
                },
                plugins: [pusat(satuan.charAt(0).toUpperCase() + satuan.slice(1), setengah)],
            });
        };
        const setengah = (id, data, satuan, khusus) => donat(id, data, satuan, khusus, true);

        @foreach ($grafiks as [$id, $judul, $ikon, $data, $satuan, $warna, $jenis])
            @if ($data->isNotEmpty())
                {{ $jenis }}('{{ $id }}', @json($data), '{{ $satuan }}',
                    @json((object) $warna));
            @endif
        @endforeach
    </script>

@endsection
