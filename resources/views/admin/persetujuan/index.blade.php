@extends('layouts.admin')

@section('title', 'Persetujuan ' . ucfirst($jenis))

@section('content')
    @php
        // Satu view untuk siswa & pegawai: $jenis ('siswa' | 'pegawai') dikirim oleh masing-masing controller.
        $adalahSiswa = $jenis === 'siswa';
        $rute = 'admin.persetujuan-' . $jenis . '.';

        $kolom = $adalahSiswa
            ? ['id' => 'NISN', 'nama' => 'Nama Siswa', 'tambahan' => 'Kelas']
            : ['id' => 'NIP', 'nama' => 'Nama', 'tambahan' => 'Jabatan'];

        $nilaiId = fn($d) => $adalahSiswa ? $d->nisn : $d->nip ?? '-';
        $nilaiNama = fn($d) => $adalahSiswa ? $d->nama_siswa : $d->nama;
        $nilaiTambahan = fn($d) => $adalahSiswa ? $d->kelas : $d->jabatan;

        $tabAtas = [
            ['siswa', 'Siswa', 'bi-people', route('admin.persetujuan-siswa.index'), $badgeSiswa],
            ['pegawai', 'Pegawai', 'bi-person-badge', route('admin.persetujuan-pegawai.index'), $badgePegawai],
        ];
    @endphp

    <x-card>
        <x-slot:header>
            <span class="font-semibold">Persetujuan Data</span>
        </x-slot:header>

        {{-- Tab atas: pindah antara siswa dan pegawai (masing-masing punya controller sendiri) --}}
        <div class="mb-4 overflow-x-auto border-b border-gray-200 dark:border-gray-700">
            <nav class="-mb-px flex min-w-max gap-1" aria-label="Jenis data">
                @foreach ($tabAtas as [$kode, $label, $ikon, $url, $jumlah])
                    @php $aktif = $kode === $jenis; @endphp
                    <a href="{{ $url }}" @if ($aktif) aria-current="page" @endif
                        class="inline-flex items-center gap-2 whitespace-nowrap border-b-2 px-4 py-2 text-sm transition {{ $aktif ? 'border-emerald-600 font-semibold text-emerald-700 dark:border-emerald-400 dark:text-emerald-300' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 dark:text-gray-400 dark:hover:border-gray-600 dark:hover:text-gray-200' }}">
                        <i class="bi {{ $ikon }}"></i> {{ $label }}
                        @if ($jumlah > 0)
                            <x-badge variant="warning" pill>{{ $jumlah }}</x-badge>
                        @endif
                    </a>
                @endforeach
            </nav>
        </div>

        <x-tabs id="persetujuanTabs">
            <x-slot:nav>
                <x-tabs.link target="tab-tambah" :active="true">
                    <i class="bi bi-person-plus me-1"></i> Tambah
                    <x-badge variant="warning" pill>{{ $menungguTambah->total() }}</x-badge>
                </x-tabs.link>
                <x-tabs.link target="tab-hapus" :active="false">
                    <i class="bi bi-person-dash me-1"></i> Hapus
                    <x-badge variant="danger" pill>{{ $menungguHapus->total() }}</x-badge>
                </x-tabs.link>
            </x-slot:nav>

            {{-- ===== Persetujuan tambah (hasil import) ===== --}}
            <x-tabs.pane id="tab-tambah" :active="true">
                @if ($ringkasanSekolah->isNotEmpty())
                    <div class="mb-4 flex flex-wrap gap-2">
                        @foreach ($ringkasanSekolah as $sekolah)
                            <form action="{{ route($rute . 'tambah.setujui-semua', $sekolah) }}" method="POST">
                                @csrf
                                <x-button type="submit" size="sm" variant="light">
                                    <i class="bi bi-check2-all me-1"></i>
                                    Setujui semua: {{ $sekolah->nama_sekolah }} ({{ $sekolah->menunggu_count }})
                                </x-button>
                            </form>
                        @endforeach
                    </div>
                @endif

                <x-table striped hover bordered class="text-sm">
                    <x-slot:head>
                        <tr class="bg-gray-100 dark:bg-gray-700">
                            <x-table.heading class="text-center">No</x-table.heading>
                            <x-table.heading class="text-center">Sekolah</x-table.heading>
                            <x-table.heading class="text-center">{{ $kolom['id'] }}</x-table.heading>
                            <x-table.heading class="min-w-48 text-center">{{ $kolom['nama'] }}</x-table.heading>
                            <x-table.heading class="text-center">{{ $kolom['tambahan'] }}</x-table.heading>
                            <x-table.heading class="min-w-40 text-center">Aksi</x-table.heading>
                        </tr>
                    </x-slot:head>

                    @forelse ($menungguTambah as $data)
                        <x-table.row>
                            <x-table.cell class="text-center">{{ $menungguTambah->firstItem() + $loop->index }}</x-table.cell>
                            <x-table.cell>{{ $data->sekolah?->nama_sekolah }}</x-table.cell>
                            <x-table.cell class="whitespace-nowrap">{{ $nilaiId($data) }}</x-table.cell>
                            <x-table.cell class="font-medium">{{ $nilaiNama($data) }}</x-table.cell>
                            <x-table.cell class="text-center">{{ $nilaiTambahan($data) }}</x-table.cell>
                            <x-table.cell class="text-center whitespace-nowrap">
                                <div class="inline-flex gap-1">
                                    <form action="{{ route($rute . 'tambah.setujui', $data) }}" method="POST">
                                        @csrf
                                        <x-button type="submit" size="sm" variant="success">Setujui</x-button>
                                    </form>
                                    <form action="{{ route($rute . 'tambah.tolak', $data) }}" method="POST">
                                        @csrf
                                        <x-button type="submit" size="sm" variant="danger">Tolak</x-button>
                                    </form>
                                </div>
                            </x-table.cell>
                        </x-table.row>
                    @empty
                        <x-table.empty colspan="6" />
                    @endforelse
                </x-table>

                <x-pagination :paginator="$menungguTambah" class="mt-4" />
            </x-tabs.pane>

            {{-- ===== Persetujuan hapus ===== --}}
            <x-tabs.pane id="tab-hapus" :active="false">
                <x-table striped hover bordered class="text-sm">
                    <x-slot:head>
                        <tr class="bg-gray-100 dark:bg-gray-700">
                            <x-table.heading class="text-center">No</x-table.heading>
                            <x-table.heading class="text-center">Sekolah</x-table.heading>
                            <x-table.heading class="text-center">{{ $kolom['id'] }}</x-table.heading>
                            <x-table.heading class="min-w-48 text-center">{{ $kolom['nama'] }}</x-table.heading>
                            <x-table.heading class="text-center">Diajukan</x-table.heading>
                            <x-table.heading class="min-w-40 text-center">Aksi</x-table.heading>
                        </tr>
                    </x-slot:head>

                    @forelse ($menungguHapus as $data)
                        <x-table.row>
                            <x-table.cell class="text-center">{{ $menungguHapus->firstItem() + $loop->index }}</x-table.cell>
                            <x-table.cell>{{ $data->sekolah?->nama_sekolah }}</x-table.cell>
                            <x-table.cell class="whitespace-nowrap">{{ $nilaiId($data) }}</x-table.cell>
                            <x-table.cell class="font-medium">{{ $nilaiNama($data) }}</x-table.cell>
                            <x-table.cell class="text-center whitespace-nowrap">{{ $data->hapus_diajukan_pada?->translatedFormat('d F Y H:i') }}</x-table.cell>
                            <x-table.cell class="text-center whitespace-nowrap">
                                <div class="inline-flex gap-1">
                                    <form action="{{ route($rute . 'hapus.setujui', $data) }}" method="POST">
                                        @csrf
                                        <x-button type="submit" size="sm" variant="danger">Setujui hapus</x-button>
                                    </form>
                                    <form action="{{ route($rute . 'hapus.tolak', $data) }}" method="POST">
                                        @csrf
                                        <x-button type="submit" size="sm" variant="light">Tolak</x-button>
                                    </form>
                                </div>
                            </x-table.cell>
                        </x-table.row>
                    @empty
                        <x-table.empty colspan="6" />
                    @endforelse
                </x-table>

                <x-pagination :paginator="$menungguHapus" class="mt-4" />
            </x-tabs.pane>
        </x-tabs>
    </x-card>
@endsection