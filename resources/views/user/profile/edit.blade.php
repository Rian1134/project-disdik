@extends('layouts.user')

@section('title', 'Profil Saya')

@section('content')
    @php
        $input =
            'w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm dark:border-gray-700 dark:bg-gray-800';
        $kartu = 'rounded-lg border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-gray-900';
        $tombol = 'rounded-lg bg-emerald-600 px-4 py-2 text-sm text-white hover:bg-emerald-700';
    @endphp

    <div class="mx-auto flex w-full max-w-xl flex-col gap-4">

        {{-- Logo --}}
        <div class="{{ $kartu }}">
            <h2 class="mb-4 font-semibold">Logo Profil</h2>

            <div class="mb-4 flex items-center gap-4">
                @if ($user->logo)
                    <img src="{{ asset('uploads/logo/' . $user->logo) }}" alt="Logo {{ $user->name }}"
                        class="h-24 w-24 rounded-full object-cover">
                @else
                    <div
                        class="flex h-24 w-24 items-center justify-center rounded-full bg-emerald-100 text-3xl text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-300">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                @endif

                <form action="{{ route('profile.logo.update') }}" method="POST" enctype="multipart/form-data" class="flex-1">
                    @csrf
                    <input type="file" name="logo" accept="image/*" class="mb-1 block w-full text-sm">
                    <p class="mb-2 text-xs text-gray-500">JPG/PNG/WEBP, maks 2 MB.</p>
                    @error('logo')
                        <p class="mb-2 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                    <button type="submit" class="{{ $tombol }}">Upload Logo</button>
                </form>
            </div>

            @if ($user->logo)
                <form action="{{ route('profile.logo.destroy') }}" method="POST">
                    @csrf @method('DELETE')
                    <button type="submit" class="text-sm text-rose-600 hover:underline">Hapus Logo</button>
                </form>
            @endif
        </div>

        {{-- Data akun --}}
        <form action="{{ route('profile.update') }}" method="POST" class="{{ $kartu }} flex flex-col gap-4">
            @csrf @method('PUT')
            <h2 class="font-semibold">Data Akun</h2>

            <div>
                <label for="name" class="mb-1 block text-sm">Nama</label>
                <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}"
                    class="{{ $input }}">
                @error('name')
                    <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="mb-1 block text-sm">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}"
                    class="{{ $input }}">
                @error('email')
                    <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <hr class="border-gray-200 dark:border-gray-800">
            <p class="text-xs text-gray-500">Kosongkan bagian password jika tidak ingin mengubahnya.</p>

            <div>
                <label for="current_password" class="mb-1 block text-sm">Password Saat Ini</label>
                <input id="current_password" type="password" name="current_password" autocomplete="current-password"
                    class="{{ $input }}">
                @error('current_password')
                    <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="mb-1 block text-sm">Password Baru</label>
                <input id="password" type="password" name="password" autocomplete="new-password"
                    class="{{ $input }}">
                @error('password')
                    <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" class="mb-1 block text-sm">Konfirmasi Password Baru</label>
                <input id="password_confirmation" type="password" name="password_confirmation" autocomplete="new-password"
                    class="{{ $input }}">
            </div>

            <div><button type="submit" class="{{ $tombol }}">Simpan Perubahan</button></div>
        </form>
    </div>
@endsection
