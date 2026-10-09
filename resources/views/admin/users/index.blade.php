@extends('layouts.admin')

@section('title', 'Manajemen User')

@section('content')
    <x-card>
        <x-slot:header>
            <div class="flex flex-wrap items-center justify-between gap-2">
                <span class="font-semibold"><i class="bi bi-person-fill-gear me-2 text-sky-500"></i>List User</span>
                <a href="{{ route('admin.users.create') }}"
                    class="inline-flex items-center gap-1.5 rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-medium text-white shadow-sm transition hover:bg-indigo-700">
                    <i class="bi bi-plus-lg"></i> Tambah User
                </a>
            </div>
        </x-slot:header>

        {{-- Pencarian langsung (JavaScript). Tanpa JS, tekan Enter tetap mencari lewat form biasa. --}}
        <form method="GET" action="{{ route('admin.users.index') }}" id="formCari" class="mb-4">
            <div class="relative max-w-sm">
                <i class="bi bi-search pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                <input type="text" id="cariUser" name="q" value="{{ $q }}" autocomplete="off"
                    data-url="{{ route('admin.users.index') }}" placeholder="Cari nama atau email..."
                    class="w-full rounded-md border border-gray-300 bg-white py-2 pl-9 pr-9 text-sm text-gray-900 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100">
                <button type="button" id="hapusCari" title="Hapus pencarian"
                    class="absolute right-2 top-1/2 -translate-y-1/2 rounded p-1 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 {{ $q === '' ? 'hidden' : '' }}">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
        </form>

        {{-- Bagian ini yang diganti oleh JavaScript saat mencari / pindah halaman --}}
        <div id="hasilUser" class="transition-opacity">
            <p class="mb-2 text-xs text-gray-500 dark:text-gray-400">
                Menampilkan <span class="font-semibold text-indigo-600 dark:text-indigo-300">{{ $users->total() }}</span>
                user
                @if ($q !== '')
                    untuk pencarian "<span class="font-medium">{{ $q }}</span>"
                @endif
            </p>

            <x-table striped hover bordered class="text-sm">
                <x-slot:head>
                    <tr class="bg-indigo-50 text-indigo-900 dark:bg-indigo-500/20 dark:text-indigo-100">
                        <x-table.heading class="text-center align-middle">No</x-table.heading>
                        <x-table.heading class="align-middle">Nama</x-table.heading>
                        <x-table.heading class="align-middle">Email</x-table.heading>
                        <x-table.heading class="align-middle">Role</x-table.heading>
                        <x-table.heading class="text-center align-middle">Aksi</x-table.heading>
                    </tr>
                </x-slot:head>

                @forelse ($users as $user)
                    <x-table.row>
                        <x-table.cell class="text-center">{{ $users->firstItem() + $loop->index }}</x-table.cell>
                        <x-table.cell>
                            <div class="flex items-center gap-2">
                                <x-avatar :name="$user->name" size="xs" />
                                <span class="font-medium text-indigo-700 dark:text-indigo-300">{{ $user->name }}</span>
                                @if ($user->id === auth()->id())
                                    <span
                                        class="rounded-full bg-emerald-100 px-2 py-0.5 text-[11px] font-medium text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-300">Anda</span>
                                @endif
                            </div>
                        </x-table.cell>
                        <x-table.cell>{{ $user->email }}</x-table.cell>
                        <x-table.cell>
                            @forelse ($user->roles as $role)
                                <span
                                    class="rounded-full bg-indigo-100 px-2 py-0.5 text-xs font-medium text-indigo-700 dark:bg-indigo-500/20 dark:text-indigo-300">{{ $role->name }}</span>
                            @empty
                                <span class="text-gray-400">-</span>
                            @endforelse
                        </x-table.cell>
                        <x-table.cell class="whitespace-nowrap text-center">
                            <div class="inline-flex items-center gap-1">
                                <a href="{{ route('admin.users.show', $user) }}" title="Detail"
                                    class="rounded border border-sky-200 bg-sky-50 px-2 py-1 text-sky-600 hover:bg-sky-100 dark:border-sky-500/30 dark:bg-sky-500/10 dark:text-sky-300 dark:hover:bg-sky-500/20">
                                    <i class="bi bi-eye-fill"></i>
                                </a>
                                <a href="{{ route('admin.users.edit', $user) }}" title="Edit"
                                    class="rounded border border-amber-200 bg-amber-50 px-2 py-1 text-amber-600 hover:bg-amber-100 dark:border-amber-500/30 dark:bg-amber-500/10 dark:text-amber-300 dark:hover:bg-amber-500/20">
                                    <i class="bi bi-pencil-fill"></i>
                                </a>
                                @if ($user->id !== auth()->id())
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline"
                                        onsubmit="return confirm(@js('Hapus user ' . $user->name . '?'))">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Hapus"
                                            class="rounded border border-rose-200 bg-rose-50 px-2 py-1 text-rose-600 hover:bg-rose-100 dark:border-rose-500/30 dark:bg-rose-500/10 dark:text-rose-300 dark:hover:bg-rose-500/20">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </x-table.cell>
                    </x-table.row>
                @empty
                    <x-table.empty colspan="5" />
                @endforelse
            </x-table>

            <x-pagination :paginator="$users" class="mt-4" />
        </div>
    </x-card>
@endsection

@push('scripts')
    <script>
        (function() {
            const form = document.getElementById('formCari');
            const input = document.getElementById('cariUser');
            const hapus = document.getElementById('hapusCari');
            const hasil = document.getElementById('hasilUser');
            if (!form || !input || !hasil) return;

            let timer = null;
            let pengendali = null; // untuk membatalkan permintaan lama

            // Bentuk URL pencarian dari isi kotak cari
            function buatUrl(kata) {
                const url = new URL(input.dataset.url, window.location.origin);
                if (kata !== '') url.searchParams.set('q', kata);
                return url.toString();
            }

            // Ambil halaman dari server, lalu ganti isi #hasilUser saja
            async function muat(url) {
                if (pengendali) pengendali.abort();
                pengendali = new AbortController();
                hasil.classList.add('opacity-50');

                try {
                    const respons = await fetch(url, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        signal: pengendali.signal,
                    });
                    if (!respons.ok) throw new Error('HTTP ' + respons.status);

                    const dokumen = new DOMParser().parseFromString(await respons.text(), 'text/html');
                    const baru = dokumen.getElementById('hasilUser');
                    if (!baru) throw new Error('Bagian hasil tidak ditemukan');

                    hasil.innerHTML = baru.innerHTML;
                    history.replaceState(null, '', url); // URL ikut berubah agar bisa di-refresh / dibagikan
                    hasil.classList.remove('opacity-50');
                } catch (e) {
                    if (e.name === 'AbortError') return; // diganti permintaan yang lebih baru
                    window.location.href = url; // cadangan: muat halaman seperti biasa
                }
            }

            // Cari otomatis setelah berhenti mengetik 300 ms
            input.addEventListener('input', function() {
                hapus.classList.toggle('hidden', input.value === '');
                clearTimeout(timer);
                timer = setTimeout(function() {
                    muat(buatUrl(input.value.trim()));
                }, 300);
            });

            // Enter = cari langsung (tanpa reload halaman)
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                clearTimeout(timer);
                muat(buatUrl(input.value.trim()));
            });

            // Tombol X: kosongkan pencarian
            hapus.addEventListener('click', function() {
                input.value = '';
                hapus.classList.add('hidden');
                clearTimeout(timer);
                muat(buatUrl(''));
                input.focus();
            });

            // Klik nomor halaman: ganti isi tabel tanpa reload
            hasil.addEventListener('click', function(e) {
                const tautan = e.target.closest('a');
                if (!tautan) return;
                const href = tautan.getAttribute('href') || '';
                if (!/[?&]page=/.test(href)) return; // hanya tautan paginasi
                e.preventDefault();
                muat(tautan.href);
            });
        })();
    </script>
@endpush
