@extends('layouts.admin')

@section('title', 'Link Ijazah')

@section('content')
    <div class="space-y-6">

        <h1 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">Link Upload Ijazah</h1>

        {{-- Form tambah link --}}
        <x-card>
            <x-slot:header>Tambah Link Baru</x-slot:header>

            <form method="POST" action="{{ route('admin.link-ijazah.store') }}" class="space-y-4">
                @csrf

                <x-form.input name="tahun" label="Tahun" type="number" :value="date('Y')" required />

                <x-form.input name="url" label="Link Upload" placeholder="https://gofile.me/xxxxxxx"
                    helper="Tempel link permintaan upload dari Synology." required />

                <x-button type="submit" variant="primary">Simpan</x-button>
            </form>
        </x-card>

        <x-card>
            <x-slot:header>Lihat di Synology</x-slot:header>
            <x-button href='#' variant="primary"><i class="bi bi-eye"></i> Lihat hasil upload</x-button>
        </x-card>

        {{-- Daftar link --}}
        <x-card>
            <x-slot:header>Daftar Link</x-slot:header>

            <x-table striped hover>
                <x-slot:head>
                    <tr>
                        <x-table.heading>No</x-table.heading>
                        <x-table.heading>Tahun</x-table.heading>
                        <x-table.heading>Link</x-table.heading>
                        <x-table.heading class="text-right">Aksi</x-table.heading>
                    </tr>
                </x-slot:head>

                @forelse ($links as $l)
                    <x-table.row>
                        <x-table.cell>{{ $links->firstItem() + $loop->index }}</x-table.cell>
                        <x-table.cell>
                            <x-badge variant="info">{{ $l->tahun }}</x-badge>
                        </x-table.cell>
                        <x-table.cell class="break-all">
                            @if (\Illuminate\Support\Str::startsWith($l->url, 'https://'))
                                <a href="{{ $l->url }}" target="_blank" rel="noopener noreferrer"
                                    class="text-blue-600 hover:underline dark:text-blue-400">
                                    {{ $l->url }}
                                </a>
                            @else
                                {{ $l->url }}
                            @endif
                        </x-table.cell>
                        <x-table.cell class="text-right">
                            <form method="POST" action="{{ route('admin.link-ijazah.destroy', $l) }}"
                                onsubmit="return confirm('Hapus link ini?')" class="inline">
                                @csrf
                                @method('DELETE')
                                <x-button type="submit" variant="danger" size="xs">
                                    <i class="bi bi-trash"></i>
                                </x-button>
                            </form>
                        </x-table.cell>
                    </x-table.row>
                @empty
                    <x-table.empty colspan="4" message="Belum ada link." />
                @endforelse

            </x-table>

            <x-pagination :paginator="$links" class="mt-4" />

        </x-card>

    </div>
@endsection
