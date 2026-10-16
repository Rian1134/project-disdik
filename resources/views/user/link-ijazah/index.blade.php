@extends('layouts.user')

@section('title', 'Upload Ijazah')

@section('content')
    <div class="space-y-6">

        <div>
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">Upload Ijazah</h1>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Pilih tahun, klik tombol Upload, lalu unggah file di halaman yang terbuka.
            </p>
        </div>

        @forelse ($links as $l)
            <x-card>
                <div class="flex items-center justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <span
                            class="inline-flex h-11 w-11 items-center justify-center rounded-lg bg-blue-50 text-xl text-blue-600 dark:bg-gray-800 dark:text-blue-400">
                            <i class="bi bi-cloud-upload"></i>
                        </span>
                        <div>
                            <p class="font-semibold text-gray-900 dark:text-gray-100">Ijazah Tahun {{ $l->tahun }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Tautan upload</p>
                        </div>
                    </div>

                    @if (\Illuminate\Support\Str::startsWith($l->url, 'https://'))
                        <x-button href="{{ $l->url }}" target="_blank" rel="noopener noreferrer" variant="primary">
                            <i class="bi bi-box-arrow-up-right me-1"></i> Upload
                        </x-button>
                    @else
                        <x-badge variant="danger">Link tidak valid</x-badge>
                    @endif
                </div>
            </x-card>
        @empty
            <x-alert type="info" :icon="true">
                Belum ada link upload. Silakan hubungi admin.
            </x-alert>
        @endforelse

    </div>
@endsection
