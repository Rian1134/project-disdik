@extends('layouts.user')

@section('title', 'Upload Ijazah')

@section('content')
    <div class="space-y-6">

        <h1 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">Upload Ijazah</h1>

        {{-- Panduan upload --}}
        <x-card>
            <x-slot:header>
                <div class="flex items-center gap-2 text-blue-600 dark:text-blue-400">
                    <i class="bi bi-info-circle"></i>
                    Cara Upload Ijazah
                </div>
            </x-slot:header>

            <p class="text-sm text-gray-500 dark:text-gray-400">
                <ol class="list-decimal mx-4">
                    <li> Isi nama sekolah di bagian "name".</li>
                    <li> Pilih file yang ingin diupload.</li>
                    <li> Klik tombol "Upload".</li>
                </ol>
            </p>
        </x-card>

        {{-- Daftar link per tahun --}}
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
                        <a href="{{ $l->url }}" target="_blank" rel="noopener noreferrer" class="inline-flex">
                            <x-button type="button" variant="primary">
                                <i class="bi bi-cloud-arrow-up me-1"></i> Upload
                            </x-button>
                        </a>
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
