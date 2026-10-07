{{--
    Komponen: Table Empty State
    Fungsi: Baris tunggal yang tampil ketika data tabel kosong.

    Props:
    - colspan : integer wajib, jumlah kolom tabel agar teks bisa merentang penuh
    - message : string, teks yang ditampilkan (default: "Belum ada data.")

    Contoh:
    @forelse($users as $user)
        <x-table.row>...</x-table.row>
    @empty
        <x-table.empty colspan="3" message="Belum ada data pengguna." />
    @endforelse
--}}
@props([
    'colspan' => 1,
    'message' => 'Belum ada data.',
])

<tr>
    <td colspan="{{ $colspan }}" {{ $attributes->class(['px-4 py-10 text-center text-sm text-gray-400 dark:text-gray-500']) }}>
        <div class="flex flex-col items-center gap-2">
            <svg class="h-8 w-8 text-gray-300 dark:text-gray-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375C2.754 3.75 2.25 4.254 2.25 4.875v1.5c0 .621.504 1.125 1.125 1.125z" />
            </svg>
            <span>{{ $message }}</span>
            {{ $slot }}
        </div>
    </td>
</tr>
