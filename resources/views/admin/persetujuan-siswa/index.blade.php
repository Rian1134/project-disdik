@extends('layouts.admin')

@section('title', 'Persetujuan Siswa')

@section('content')
    <x-card>
        <x-slot:header>
            <span class="font-semibold">Persetujuan Siswa</span>
        </x-slot:header>

        <x-tabs id="persetujuanSiswaTabs">
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
                            <form action="{{ route('admin.persetujuan-siswa.tambah.setujui-semua', $sekolah) }}"
                                method="POST">
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
                            <x-table.heading class="text-center">NISN</x-table.heading>
                            <x-table.heading class="min-w-48 text-center">Nama Siswa</x-table.heading>
                            <x-table.heading class="text-center">Kelas</x-table.heading>
                            <x-table.heading class="min-w-40 text-center">Aksi</x-table.heading>
                        </tr>
                    </x-slot:head>

                    @forelse ($menungguTambah as $siswa)
                        <x-table.row>
                            <x-table.cell
                                class="text-center">{{ $menungguTambah->firstItem() + $loop->index }}</x-table.cell>
                            <x-table.cell>{{ $siswa->sekolah?->nama_sekolah }}</x-table.cell>
                            <x-table.cell class="whitespace-nowrap">{{ $siswa->nisn }}</x-table.cell>
                            <x-table.cell class="font-medium">{{ $siswa->nama_siswa }}</x-table.cell>
                            <x-table.cell class="text-center">{{ $siswa->kelas }}</x-table.cell>
                            <x-table.cell class="text-center whitespace-nowrap">
                                <div class="inline-flex gap-1">
                                    <form action="{{ route('admin.persetujuan-siswa.tambah.setujui', $siswa) }}"
                                        method="POST">
                                        @csrf
                                        <x-button type="submit" size="sm" variant="success">Setujui</x-button>
                                    </form>
                                    <form action="{{ route('admin.persetujuan-siswa.tambah.tolak', $siswa) }}"
                                        method="POST">
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
                            <x-table.heading class="text-center">NISN</x-table.heading>
                            <x-table.heading class="min-w-48 text-center">Nama Siswa</x-table.heading>
                            <x-table.heading class="text-center">Diajukan</x-table.heading>
                            <x-table.heading class="min-w-40 text-center">Aksi</x-table.heading>
                        </tr>
                    </x-slot:head>

                    @forelse ($menungguHapus as $siswa)
                        <x-table.row>
                            <x-table.cell
                                class="text-center">{{ $menungguHapus->firstItem() + $loop->index }}</x-table.cell>
                            <x-table.cell>{{ $siswa->sekolah?->nama_sekolah }}</x-table.cell>
                            <x-table.cell class="whitespace-nowrap">{{ $siswa->nisn }}</x-table.cell>
                            <x-table.cell class="font-medium">{{ $siswa->nama_siswa }}</x-table.cell>
                            <x-table.cell
                                class="text-center whitespace-nowrap">{{ $siswa->hapus_diajukan_pada?->translatedFormat('d F Y H:i') }}</x-table.cell>
                            <x-table.cell class="text-center whitespace-nowrap">
                                <div class="inline-flex gap-1">
                                    <form action="{{ route('admin.persetujuan-siswa.hapus.setujui', $siswa) }}"
                                        method="POST">
                                        @csrf
                                        <x-button type="submit" size="sm" variant="danger">Setujui hapus</x-button>
                                    </form>
                                    <form action="{{ route('admin.persetujuan-siswa.hapus.tolak', $siswa) }}"
                                        method="POST">
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
