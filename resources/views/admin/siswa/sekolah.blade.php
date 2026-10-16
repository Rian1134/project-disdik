@extends('layouts.admin')

@section('title', 'Data Siswa')

@section('content')
    @php
        // Kategori tab filter: tingkat dari nama kelas ("VII" -> "VII", "VII A" -> "VII", data lama "7 A" -> "7")
        $tingkat = function ($kelas) {
            $kelas = trim((string) $kelas);

            return preg_match('/^\d+/', $kelas, $cocok) ? $cocok[0] : (strtok($kelas, ' ') ?: '-');
        };
    @endphp

    <x-card>
        <x-slot:header>
            <div class="flex flex-wrap items-center justify-between gap-2">
                <span class="font-semibold"><i class="bi bi-people-fill me-2 text-emerald-500"></i>Siswa
                    {{ $sekolah->nama_sekolah }}</span>
                <div class="flex gap-2">
                    <x-button href="{{ route('admin.siswa.index') }}" variant="light" size="sm">Kembali</x-button>
                    <x-button href="{{ route('admin.siswa.create', ['sekolah_id' => $sekolah->id]) }}" size="sm">
                        <i class="bi bi-plus-lg me-1"></i> Tambah
                    </x-button>
                </div>
            </div>
        </x-slot:header>

        {{-- Tab filter kategori (diisi oleh JavaScript di bawah) --}}
        <div class="mb-4 hidden overflow-x-auto border-b border-gray-200 dark:border-gray-700">
            <nav id="tabKategori" class="-mb-px flex min-w-max gap-1" aria-label="Filter kelas"></nav>
        </div>

        <div class="relative mb-4 max-w-sm">
            <i class="bi bi-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
            <input id="cariSiswa" type="search" placeholder="Cari nama, NISN, NIK, kelas..."
                class="w-full rounded-lg border border-gray-300 bg-white py-2 pl-9 pr-3 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-800">
        </div>

        <div id="daftarSiswa">
            <x-table striped hover bordered class="text-sm">
                <x-slot:head>
                    <tr class="bg-indigo-50 text-indigo-900 dark:bg-indigo-500/20 dark:text-indigo-100">
                        <x-table.heading class="text-center">No</x-table.heading>
                        <x-table.heading class="text-center">NIK</x-table.heading>
                        <x-table.heading class="text-center">NISN</x-table.heading>
                        <x-table.heading class="min-w-48 text-center">Nama Siswa</x-table.heading>
                        <x-table.heading class="text-center">Kelas</x-table.heading>
                        <x-table.heading class="text-center">L/P</x-table.heading>
                        <x-table.heading class="text-center">Status Pelajar</x-table.heading>
                        <x-table.heading class="min-w-28 text-center">Aksi</x-table.heading>
                    </tr>
                </x-slot:head>

                @forelse($siswas as $siswa)
                    <x-table.row>
                        <x-table.cell class="text-center">{{ $loop->iteration }}</x-table.cell>
                        <x-table.cell class="whitespace-nowrap">{{ $siswa->nik }}</x-table.cell>
                        <x-table.cell class="whitespace-nowrap">{{ $siswa->nisn }}</x-table.cell>
                        <x-table.cell
                            class="font-medium text-indigo-700 dark:text-indigo-300">{{ $siswa->nama_siswa }}</x-table.cell>
                        <x-table.cell class="text-center"><span
                                data-kategori="{{ $tingkat($siswa->kelas) }}">{{ $siswa->kelas }}</span></x-table.cell>
                        <x-table.cell
                            class="text-center font-semibold {{ $siswa->jenis_kelamin === 'L' ? 'text-sky-600 dark:text-sky-300' : 'text-rose-500 dark:text-rose-300' }}">{{ $siswa->jenis_kelamin }}</x-table.cell>
                        <x-table.cell class="text-center">
                            <x-badge :variant="$siswa->status_pelajar === 'Aktif' ? 'success' : 'secondary'" pill>{{ $siswa->status_pelajar }}</x-badge>
                        </x-table.cell>
                        <x-table.cell class="text-center whitespace-nowrap">
                            <div class="inline-flex items-center gap-1">
                                <a href="{{ route('admin.siswa.show', $siswa) }}" title="Detail"
                                    class="rounded border border-sky-200 bg-sky-50 px-2 py-1 text-sky-600 hover:bg-sky-100 dark:border-sky-500/30 dark:bg-sky-500/10 dark:text-sky-300 dark:hover:bg-sky-500/20">
                                    <i class="bi bi-eye-fill"></i>
                                </a>
                                <a href="{{ route('admin.siswa.edit', $siswa) }}" title="Edit"
                                    class="rounded border border-amber-200 bg-amber-50 px-2 py-1 text-amber-600 hover:bg-amber-100 dark:border-amber-500/30 dark:bg-amber-500/10 dark:text-amber-300 dark:hover:bg-amber-500/20">
                                    <i class="bi bi-pencil-fill"></i>
                                </a>
                                <button type="button" data-modal-open="hapus-{{ $siswa->id }}" title="Hapus"
                                    class="rounded border border-rose-200 bg-rose-50 px-2 py-1 text-rose-600 hover:bg-rose-100 dark:border-rose-500/30 dark:bg-rose-500/10 dark:text-rose-300 dark:hover:bg-rose-500/20">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </div>

                            <x-modal id="hapus-{{ $siswa->id }}" size="sm" centered>
                                <x-slot:header><i
                                        class="bi bi-exclamation-triangle-fill me-2 text-rose-500"></i>Konfirmasi
                                    Hapus</x-slot:header>

                                <p class="text-center text-sm">
                                    Yakin ingin menghapus <strong>{{ $siswa->nama_siswa }}</strong>?
                                </p>

                                <x-slot:footer>
                                    <x-button variant="light" data-modal-close>Batal</x-button>
                                    <form action="{{ route('admin.siswa.destroy', $siswa) }}" method="POST"
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
                    <x-table.empty colspan="8" />
                @endforelse
            </x-table>
        </div>
        <p id="cariKosong" class="hidden py-6 text-center text-sm text-gray-500 dark:text-gray-400">
            Tidak ada siswa yang cocok.
        </p>

        <div class="mt-4 flex flex-wrap items-center justify-between gap-3">
            <p id="infoData" class="text-sm text-gray-500 dark:text-gray-400"></p>
            <div id="pagerData" class="flex flex-wrap items-center gap-1"></div>
        </div>
    </x-card>

    <script>
        // Tab kelas + pencarian + paginasi, semuanya di sisi browser (tanpa reload halaman).
        (function() {
            const PER_HALAMAN = 15;

            const cari = document.getElementById('cariSiswa');
            const kosong = document.getElementById('cariKosong');
            const wadahTab = document.getElementById('tabKategori');
            const wadahPager = document.getElementById('pagerData');
            const info = document.getElementById('infoData');

            // Hanya baris data (punya penanda kategori); baris "data kosong" bawaan tabel tidak ikut.
            const baris = [...document.querySelectorAll('#daftarSiswa tbody tr')]
                .filter(tr => tr.querySelector('[data-kategori]'));

            const kategoriBaris = new Map(); // tr -> kategori
            const teksBaris = new Map(); // tr -> teks untuk pencarian
            const hitung = {}; // kategori -> jumlah baris

            baris.forEach(tr => {
                const k = tr.querySelector('[data-kategori]').dataset.kategori;
                kategoriBaris.set(tr, k);
                // kolom No (pertama) dan Aksi (terakhir) tidak ikut dicari
                teksBaris.set(tr, [...tr.cells].slice(1, -1).map(td => td.textContent).join(' ').toLowerCase());
                hitung[k] = (hitung[k] || 0) + 1;
            });

            // Urutan tab: kelas romawi dulu (VII, VIII, IX), sisanya menyusul
            const urutKelas = ['VII', 'VIII', 'IX'];
            const posisi = k => (urutKelas.includes(k) ? urutKelas.indexOf(k) : urutKelas.length);
            const daftarKategori = Object.keys(hitung)
                .sort((a, b) => posisi(a) - posisi(b) || a.localeCompare(b, 'id', {
                    numeric: true
                }));

            let kategoriAktif = '';
            let halaman = 1;

            const labelKategori = k => (k === '-' ? 'Lainnya' : 'Kelas ' + k);

            const dasarTab = 'inline-flex items-center gap-2 whitespace-nowrap border-b-2 px-3 py-2 text-sm transition';
            const tabAktif =
                'border-indigo-600 font-semibold text-indigo-700 dark:border-indigo-400 dark:text-indigo-300';
            const tabBiasa =
                'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 dark:text-gray-400 dark:hover:border-gray-600 dark:hover:text-gray-200';

            function buatTab() {
                if (!wadahTab || daftarKategori.length === 0) return;

                const semua = [
                    ['', 'Semua', baris.length]
                ].concat(daftarKategori.map(k => [k, labelKategori(k), hitung[k]]));

                wadahTab.innerHTML = '';
                semua.forEach(([nilai, label, jumlah]) => {
                    const tombol = document.createElement('button');
                    tombol.type = 'button';
                    tombol.dataset.nilai = nilai;
                    tombol.innerHTML =
                        '<span></span><span class="rounded-full bg-gray-100 px-2 py-0.5 text-xs dark:bg-gray-800"></span>';
                    tombol.children[0].textContent = label;
                    tombol.children[1].textContent = jumlah;
                    tombol.addEventListener('click', () => {
                        kategoriAktif = nilai;
                        halaman = 1;
                        terapkan();
                    });
                    wadahTab.appendChild(tombol);
                });

                wadahTab.parentElement.classList.remove('hidden');
            }

            function tandaiTab() {
                if (!wadahTab) return;
                wadahTab.querySelectorAll('button').forEach(tombol => {
                    const on = tombol.dataset.nilai === kategoriAktif;
                    tombol.className = dasarTab + ' ' + (on ? tabAktif : tabBiasa);
                    if (on) {
                        tombol.setAttribute('aria-current', 'page');
                    } else {
                        tombol.removeAttribute('aria-current');
                    }
                });
            }

            function buatPager(jumlahHal) {
                if (!wadahPager) return;
                wadahPager.innerHTML = '';
                if (jumlahHal <= 1) return;

                const tambah = (teks, tujuan, nonaktif, aktif) => {
                    const b = document.createElement('button');
                    b.type = 'button';
                    b.textContent = teks;
                    b.disabled = !!nonaktif;
                    b.className = 'min-w-9 rounded-md border px-2.5 py-1 text-sm transition ' +
                        (aktif ?
                            'border-indigo-600 bg-indigo-600 text-white' :
                            'border-gray-300 text-gray-600 hover:bg-gray-100 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700'
                        ) +
                        (nonaktif ? ' cursor-not-allowed opacity-50' : '');
                    if (!nonaktif) {
                        b.addEventListener('click', () => {
                            halaman = tujuan;
                            terapkan();
                        });
                    }
                    wadahPager.appendChild(b);
                };

                tambah('‹', halaman - 1, halaman === 1);
                const awal = Math.max(1, Math.min(halaman - 2, jumlahHal - 4));
                const akhir = Math.min(jumlahHal, awal + 4);
                for (let p = awal; p <= akhir; p++) {
                    tambah(String(p), p, false, p === halaman);
                }
                tambah('›', halaman + 1, halaman === jumlahHal);
            }

            function terapkan() {
                const kata = cari.value.trim().toLowerCase();

                const cocok = baris.filter(tr =>
                    (!kategoriAktif || kategoriBaris.get(tr) === kategoriAktif) &&
                    teksBaris.get(tr).includes(kata)
                );

                const jumlahHal = Math.max(1, Math.ceil(cocok.length / PER_HALAMAN));
                halaman = Math.min(halaman, jumlahHal);

                const awal = (halaman - 1) * PER_HALAMAN;
                const tampil = cocok.slice(awal, awal + PER_HALAMAN);
                const setTampil = new Set(tampil);

                baris.forEach(tr => {
                    tr.style.display = setTampil.has(tr) ? '' : 'none';
                });

                // nomor urut mengikuti hasil filter
                tampil.forEach((tr, i) => {
                    tr.cells[0].textContent = awal + i + 1;
                });

                if (kosong) kosong.classList.toggle('hidden', cocok.length > 0 || baris.length === 0);
                if (info) {
                    info.textContent = cocok.length ?
                        'Menampilkan ' + (awal + 1) + '–' + (awal + tampil.length) + ' dari ' + cocok.length +
                        ' siswa' :
                        '';
                }

                buatPager(jumlahHal);
                tandaiTab();
            }

            buatTab();
            cari.addEventListener('input', () => {
                halaman = 1;
                terapkan();
            });
            terapkan();
        })();
    </script>
@endsection
