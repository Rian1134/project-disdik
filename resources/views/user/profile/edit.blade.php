@extends('layouts.user')

@section('title', 'Edit Profil')

@section('content')
    @php
        $logoUrl = $user->logo_url;
        $inputClass =
            'block w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-800 placeholder-gray-400 focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/30 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 dark:placeholder-gray-500';
        $labelClass = 'mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300';
        $cardClass = 'rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900';
        $eyeClass =
            'absolute inset-y-0 right-0 flex items-center px-3 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200';
    @endphp

    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-semibold text-gray-800 dark:text-gray-100">Edit Profil</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">Kelola logo, data akun, dan password Anda.</p>
        </div>
        <a href="{{ route('user.profile.index') }}" class="text-sm text-emerald-600 hover:underline">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="grid grid-cols-1 gap-4 lg:grid-cols-3">

        {{-- ===== KARTU LOGO ===== --}}
        <div class="{{ $cardClass }} lg:col-span-1 h-fit">
            <div class="border-b border-gray-100 px-4 py-3 dark:border-gray-800">
                <h2 class="text-sm font-semibold text-gray-800 dark:text-gray-100">
                    <i class="bi bi-image me-2 text-emerald-600 dark:text-emerald-400"></i>Logo
                </h2>
            </div>

            <div class="flex flex-col items-center gap-4 p-4">
                {{-- Preview: gambar tersimpan / inisial nama --}}
                <img id="logoPreview" @if ($logoUrl) src="{{ $logoUrl }}" @endif alt="Logo"
                    class="h-32 w-32 rounded-full border border-gray-200 object-cover dark:border-gray-700 {{ $logoUrl ? '' : 'hidden' }}">
                <div id="logoFallback"
                    class="{{ $logoUrl ? 'hidden' : 'flex' }} h-32 w-32 items-center justify-center rounded-full bg-emerald-100 text-4xl text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-300">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>

                {{-- Form upload logo --}}
                <form action="{{ route('user.profile.logo.update') }}" method="POST" enctype="multipart/form-data"
                    class="w-full space-y-3">
                    @csrf

                    <div>
                        <label for="logo" class="{{ $labelClass }}">Pilih gambar</label>
                        <input type="file" id="logo" name="logo" accept="image/png,image/jpeg,image/webp"
                            required
                            class="block w-full cursor-pointer rounded-lg border border-gray-300 bg-white text-sm text-gray-600 file:mr-3 file:cursor-pointer file:border-0 file:bg-emerald-50 file:px-3 file:py-2 file:text-sm file:font-medium file:text-emerald-700 hover:file:bg-emerald-100 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:file:bg-emerald-500/15 dark:file:text-emerald-300">
                        <p class="mt-1 text-xs text-gray-400 dark:text-gray-500">
                            JPG, PNG, atau WEBP. Maksimal 2 MB. Otomatis dipotong persegi (400 &times; 400 px).
                        </p>
                        @error('logo')
                            <p class="mt-1 text-xs text-rose-600 dark:text-rose-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex flex-wrap gap-2">
                        <x-button type="submit" variant="success" class="flex-1">
                            <i class="bi bi-upload me-1"></i> Simpan Logo
                        </x-button>
                        @if ($logoUrl)
                            <x-button type="button" variant="danger" data-modal-open="hapusLogoModal">
                                <i class="bi bi-trash"></i>
                                <span class="sr-only">Hapus logo</span>
                            </x-button>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        {{-- ===== KARTU DATA AKUN & PASSWORD ===== --}}
        <div class="{{ $cardClass }} lg:col-span-2">
            <div class="border-b border-gray-100 px-4 py-3 dark:border-gray-800">
                <h2 class="text-sm font-semibold text-gray-800 dark:text-gray-100">
                    <i class="bi bi-person-circle me-2 text-emerald-600 dark:text-emerald-400"></i>Data Akun
                </h2>
            </div>

            <form action="{{ route('user.profile.update') }}" method="POST" class="space-y-6 p-4">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label for="name" class="{{ $labelClass }}">Nama</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required
                            class="{{ $inputClass }}">
                        @error('name')
                            <p class="mt-1 text-xs text-rose-600 dark:text-rose-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="{{ $labelClass }}">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}"
                            required class="{{ $inputClass }}">
                        @error('email')
                            <p class="mt-1 text-xs text-rose-600 dark:text-rose-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Ganti password (opsional) --}}
                <div class="border-t border-gray-100 pt-4 dark:border-gray-800">
                    <h3 class="text-sm font-semibold text-gray-800 dark:text-gray-100">Ganti Password</h3>
                    <p class="mb-4 text-xs text-gray-500 dark:text-gray-400">
                        Kosongkan jika tidak ingin mengubah password.
                    </p>

                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div class="sm:col-span-2">
                            <label for="current_password" class="{{ $labelClass }}">Password saat ini</label>
                            <div class="relative">
                                <input type="password" id="current_password" name="current_password"
                                    autocomplete="current-password" class="{{ $inputClass }} pr-10">
                                <button type="button" data-toggle-password="current_password" class="{{ $eyeClass }}"
                                    aria-label="Tampilkan password" title="Tampilkan password">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                            @error('current_password')
                                <p class="mt-1 text-xs text-rose-600 dark:text-rose-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password" class="{{ $labelClass }}">Password baru</label>
                            <div class="relative">
                                <input type="password" id="password" name="password" autocomplete="new-password"
                                    class="{{ $inputClass }} pr-10">
                                <button type="button" data-toggle-password="password" class="{{ $eyeClass }}"
                                    aria-label="Tampilkan password" title="Tampilkan password">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                            <p class="mt-1 text-xs text-gray-400 dark:text-gray-500">Minimal 8 karakter.</p>
                            @error('password')
                                <p class="mt-1 text-xs text-rose-600 dark:text-rose-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password_confirmation" class="{{ $labelClass }}">Konfirmasi password
                                baru</label>
                            <div class="relative">
                                <input type="password" id="password_confirmation" name="password_confirmation"
                                    autocomplete="new-password" class="{{ $inputClass }} pr-10">
                                <button type="button" data-toggle-password="password_confirmation"
                                    class="{{ $eyeClass }}" aria-label="Tampilkan password"
                                    title="Tampilkan password">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end">
                    <x-button type="submit" variant="success">
                        <i class="bi bi-check-lg me-1"></i> Simpan Perubahan
                    </x-button>
                </div>
            </form>
        </div>
    </div>

    {{-- ===== MODAL KONFIRMASI HAPUS LOGO ===== --}}
    @if ($logoUrl)
        <x-modal id="hapusLogoModal" size="sm" centered>
            <x-slot:header>
                <i class="bi bi-trash me-2 text-rose-500"></i>Hapus Logo
            </x-slot:header>

            <p class="text-center text-sm">Yakin ingin menghapus logo Anda?</p>

            <x-slot:footer>
                <x-button variant="light" data-modal-close>Batal</x-button>
                <form action="{{ route('user.profile.logo.destroy') }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <x-button type="submit" variant="danger">Hapus</x-button>
                </form>
            </x-slot:footer>
        </x-modal>
    @endif
@endsection

@push('scripts')
    <script>
        // Preview logo yang dipilih sebelum diupload
        document.getElementById('logo')?.addEventListener('change', function() {
            var file = this.files && this.files[0];
            if (!file) return;

            var preview = document.getElementById('logoPreview');
            var fallback = document.getElementById('logoFallback');

            preview.src = URL.createObjectURL(file);
            preview.classList.remove('hidden');
            fallback.classList.add('hidden');
            fallback.classList.remove('flex');
        });

        // Tampilkan / sembunyikan password
        document.querySelectorAll('[data-toggle-password]').forEach(function(btn) {
            btn.addEventListener('click', function() {
                var input = document.getElementById(this.dataset.togglePassword);
                if (!input) return;

                var tampil = input.type === 'password';
                input.type = tampil ? 'text' : 'password';

                var ikon = this.querySelector('i');
                ikon.classList.toggle('bi-eye', !tampil);
                ikon.classList.toggle('bi-eye-slash', tampil);

                var teks = tampil ? 'Sembunyikan password' : 'Tampilkan password';
                this.setAttribute('aria-label', teks);
                this.title = teks;
            });
        });
    </script>
@endpush
