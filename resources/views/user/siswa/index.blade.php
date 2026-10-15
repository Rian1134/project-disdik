@extends('layouts.user')

@section('title', 'Data Siswa')

@section('content')
    @php
        // Kategori tab filter: tingkat dari nama kelas ("7 A" -> "7", "VII A" -> "VII")
        $tingkat = function ($kelas) {
            $kelas = trim((string) $kelas);

            return preg_match('/^\d+/', $kelas, $cocok) ? $cocok[0] : (strtok($kelas, ' ') ?: '-');
        };
    @endphp

    @if (!$sekolah)
        <div
            class="mb-4 flex items-start gap-3 rounded-lg border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-800 dark:border-amber-800 dark:bg-amber-900/30 dark:text-amber-200">
            <i class="bi bi-info-circle-fill mt-0.5"></i>
            <p>
                Profil sekolah kamu belum diisi, jadi data siswa belum bisa ditambahkan.
                <a href="{{ route('user.sekolah.index') }}" class="font-semibold underline">Lengkapi Profil Sekolah</a>
            </p>
        </div>
    @endif

    @if ($jumlahMenunggu > 0)
        <div
            class="mb-4 flex items-start gap-3 rounded-lg border border-blue-200 bg-blue-50 px-4 py-3 text-sm text-blue-800 dark:border-blue-800 dark:bg-blue-900/30 dark:text-blue-200">
            <i class="bi bi-hourglass-split mt-0.5"></i>
            <p>{{ $jumlahMenunggu }} siswa hasil import sedang menunggu persetujuan admin dan belum tampil di daftar ini.
            </p>
        </div>
    @endif

    <x-card>
        <x-slot:header>
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div class="flex min-w-0 items-center gap-3">
                    <span
                        class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-emerald-600 text-lg text-white">
                        <i class="bi bi-people-fill"></i>
                    </span>
                    <div class="min-w-0">
                        <h2 class="truncate font-semibold leading-tight">
                            {{ $sekolah ? 'Siswa ' . $sekolah->nama_sekolah : 'Data Siswa' }}
                        </h2>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Total {{ $siswas->count() }} siswa</p>
                    </div>
                </div>
                @if ($sekolah)
                    <x-button href="{{ route('user.siswa.create') }}" size="sm">
                        <i class="bi bi-plus-lg me-1"></i> Tambah Siswa
                    </x-button>
                @endif
            </div>
        </x-slot:header>

        {{-- Tab filter kategori (diisi oleh JavaScript di bawah) --}}
        <div class="mb-4 hidden overflow-x-auto pb-1">
            <nav id="tabKategori" class="flex min-w-max gap-2" aria-label="Filter kategori"></nav>
        </div>

        <div class="relative mb-4 max-w-sm">
            <i class="bi bi-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
            <input id="cariSiswa" type="search" placeholder="Cari nama, NISN, NIK, kelas..."
                class="w-full rounded-lg border border-gray-300 bg-white py-2 pl-9 pr-3 text-sm focus:border-emerald-500 focus:outline-none focus:ring-1 focus:ring-emerald-500 dark:border-gray-600 dark:bg-gray-800">
        </div>

        <div id="daftarSiswa">
            <x-table hover class="text-sm">
                <x-slot:head>
                    <tr
                        class="bg-emerald-50 text-xs uppercase tracking-wide text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-300">
                        <x-table.heading class="text-center">No</x-table.heading>
                        <x-table.heading class="min-w-56">Siswa</x-table.heading>
                        <x-table.heading class="text-center">Kelas</x-table.heading>
                        <x-table.heading class="text-center">L/P</x-table.heading>
                        <x-table.heading class="text-center">Status</x-table.heading>
                        <x-table.heading class="min-w-28 text-center">Aksi</x-table.heading>
                    </tr>
                </x-slot:head>

                @forelse($siswas as $siswa)
                    @php
                        $warnaJk =
                            $siswa->jenis_kelamin === 'L'
                                ? 'bg-sky-50 text-sky-700 dark:bg-sky-500/15 dark:text-sky-300'
                                : 'bg-rose-50 text-rose-700 dark:bg-rose-500/15 dark:text-rose-300';
                    @endphp
                    <x-table.row>
                        <x-table.cell class="text-center text-gray-500">{{ $loop->iteration }}</x-table.cell>
                        <x-table.cell>
                            <div class="flex items-center gap-3">
                                <span
                                    class="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-full text-sm font-semibold {{ $warnaJk }}">
                                    {{ mb_strtoupper(mb_substr($siswa->nama_siswa, 0, 1)) }}
                                </span>
                                <div class="min-w-0">
                                    <p class="font-medium">{{ $siswa->nama_siswa }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        NISN {{ $siswa->nisn }} &middot; NIK {{ $siswa->nik }}
                                    </p>
                                </div>
                            </div>
                        </x-table.cell>
                        <x-table.cell class="text-center whitespace-nowrap"><span
                                data-kategori="{{ $tingkat($siswa->kelas) }}">{{ $siswa->kelas }}</span></x-table.cell>
                        <x-table.cell class="text-center">
                            <span
                                class="inline-flex h-6 w-6 items-center justify-center rounded-full text-xs font-semibold {{ $warnaJk }}">
                                {{ $siswa->jenis_kelamin }}
                            </span>
                        </x-table.cell>
                        <x-table.cell class="text-center">
                            <div class="flex flex-col items-center gap-1">
                                <x-badge :variant="$siswa->status_pelajar === 'Aktif' ? 'success' : 'secondary'" pill>{{ $siswa->status_pelajar }}</x-badge>
                                @if ($siswa->isMenungguHapus())
                                    <x-badge variant="warning" pill>Menunggu hapus</x-badge>
                                @endif
                            </div>
                        </x-table.cell>
                        <x-table.cell class="text-center whitespace-nowrap">
                            <div class="inline-flex items-center gap-1">
                                <a href="{{ route('user.siswa.show', $siswa) }}" title="Detail"
                                    class="rounded-md border border-gray-200 px-2 py-1 text-sky-600 hover:bg-sky-50 dark:border-gray-700 dark:text-sky-400 dark:hover:bg-sky-500/10">
                                    <i class="bi bi-eye-fill"></i>
                                </a>
                                <a href="{{ route('user.siswa.edit', $siswa) }}" title="Edit"
                                    class="rounded-md border border-gray-200 px-2 py-1 text-amber-600 hover:bg-amber-50 dark:border-gray-700 dark:text-amber-400 dark:hover:bg-amber-500/10">
                                    <i class="bi bi-pencil-fill"></i>
                                </a>
                                @if ($siswa->isMenungguHapus())
                                    <span title="Pengajuan hapus menunggu admin"
                                        class="cursor-not-allowed rounded-md border border-gray-200 px-2 py-1 text-gray-400 dark:border-gray-700">
                                        <i class="bi bi-hourglass-split"></i>
                                    </span>
                                @else
                                    <button type="button" data-modal-open="hapus-{{ $siswa->id }}"
                                        title="{{ $siswa->isDariImport() ? 'Ajukan hapus' : 'Hapus' }}"
                                        class="rounded-md border border-gray-200 px-2 py-1 text-rose-600 hover:bg-rose-50 dark:border-gray-700 dark:text-rose-400 dark:hover:bg-rose-500/10">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                @endif
                            </div>

                            @unless ($siswa->isMenungguHapus())
                                <x-modal id="hapus-{{ $siswa->id }}" size="sm" centered>
                                    <x-slot:header>{{ $siswa->isDariImport() ? 'Ajukan Penghapusan' : 'Konfirmasi Hapus' }}</x-slot:header>

                                    <div class="flex flex-col items-center gap-3 text-center text-sm">
                                        <span
                                            class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-rose-50 text-xl text-rose-600 dark:bg-rose-500/15 dark:text-rose-300">
                                            <i class="bi bi-trash-fill"></i>
                                        </span>
                                        <p>
                                            @if ($siswa->isDariImport())
                                                Ajukan penghapusan <strong>{{ $siswa->nama_siswa }}</strong>?
                                                Data baru dihapus setelah disetujui admin.
                                            @else
                                                Yakin ingin menghapus <strong>{{ $siswa->nama_siswa }}</strong>?
                                            @endif
                                        </p>
                                    </div>

                                    <x-slot:footer>
                                        <x-button variant="light" data-modal-close>Batal</x-button>
                                        <form action="{{ route('user.siswa.destroy', $siswa) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <x-button type="submit"
                                                variant="danger">{{ $siswa->isDariImport() ? 'Ajukan' : 'Hapus' }}</x-button>
                                        </form>
                                    </x-slot:footer>
                                </x-modal>
                            @endunless
                        </x-table.cell>
                    </x-table.row>
                @empty
                    <x-table.empty colspan="6" />
                @endforelse
            </x-table>
        </div>
        <p id="cariKosong" class="hidden py-6 text-center text-sm text-gray-500 dark:text-gray-400">
            Tidak ada siswa yang cocok.
        </p>

        <div class="mt-4 flex flex-col items-center justify-between gap-3 sm:flex-row">
            <p id="infoData" class="text-sm text-gray-500 dark:text-gray-400"></p>
            <div id="pagerData" class="flex flex-wrap items-center gap-1"></div>
        </div>
    </x-card>

    <script>
        // Tab kategori + pencarian + paginasi, semuanya di sisi browser (tanpa reload halaman).
        (function() {
            const PER_HALAMAN = 20;

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

            const daftarKategori = Object.keys(hitung)
                .sort((a, b) => a.localeCompare(b, 'id', {
                    numeric: true
                }));

            let kategoriAktif = '';
            let halaman = 1;

            const labelKategori = k => (k === '-' ? 'Lainnya' : 'Kelas ' + k);

            // Warna tab: [aktif, biasa]. Kelas ditulis utuh agar terbaca Tailwind.
            // Tab "Semua" memakai hijau; tingkat kelas lain bergantian memakai warna berikutnya.
            const warnaTab = [
                ['bg-emerald-600 text-white',
                    'bg-emerald-50 text-emerald-700 hover:bg-emerald-100 dark:bg-emerald-500/15 dark:text-emerald-300 dark:hover:bg-emerald-500/25'
                ],
                ['bg-sky-600 text-white',
                    'bg-sky-50 text-sky-700 hover:bg-sky-100 dark:bg-sky-500/15 dark:text-sky-300 dark:hover:bg-sky-500/25'
                ],
                ['bg-violet-600 text-white',
                    'bg-violet-50 text-violet-700 hover:bg-violet-100 dark:bg-violet-500/15 dark:text-violet-300 dark:hover:bg-violet-500/25'
                ],
                ['bg-amber-500 text-white',
                    'bg-amber-50 text-amber-700 hover:bg-amber-100 dark:bg-amber-500/15 dark:text-amber-300 dark:hover:bg-amber-500/25'
                ],
                ['bg-rose-600 text-white',
                    'bg-rose-50 text-rose-700 hover:bg-rose-100 dark:bg-rose-500/15 dark:text-rose-300 dark:hover:bg-rose-500/25'
                ],
                ['bg-teal-600 text-white',
                    'bg-teal-50 text-teal-700 hover:bg-teal-100 dark:bg-teal-500/15 dark:text-teal-300 dark:hover:bg-teal-500/25'
                ],
            ];
            const dasarTab =
                'inline-flex items-center gap-2 whitespace-nowrap rounded-full px-3.5 py-1.5 text-sm transition';
            const warnaTabKe = i => warnaTab[i === 0 ? 0 : 1 + ((i - 1) % (warnaTab.length - 1))];

            function buatTab() {
                if (!wadahTab || daftarKategori.length === 0) return;

                const semua = [
                    ['', 'Semua', baris.length]
                ].concat(daftarKategori.map(k => [k, labelKategori(k), hitung[k]]));

                wadahTab.innerHTML = '';
                semua.forEach(([nilai, label, jumlah], i) => {
                    const tombol = document.createElement('button');
                    tombol.type = 'button';
                    tombol.dataset.nilai = nilai;
                    tombol.dataset.warna = i;
                    tombol.innerHTML = '<span></span><span></span>';
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
                    const [aktif, biasa] = warnaTabKe(Number(tombol.dataset.warna));
                    tombol.className = dasarTab + ' ' + (on ? aktif + ' font-semibold shadow-sm' : biasa);
                    tombol.children[1].className = 'rounded-full px-2 py-0.5 text-xs ' +
                        (on ? 'bg-white/25' : 'bg-white/70 dark:bg-gray-900/40');
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
                            'border-emerald-600 bg-emerald-600 text-white' :
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
