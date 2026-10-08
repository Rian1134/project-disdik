@extends('layouts.admin')

@section('title', 'Edit User')

@section('content')
@php
    $input = 'w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100';
    $label = 'mb-1 block text-sm font-medium text-gray-700 dark:text-gray-200';
@endphp

<x-card>
    <x-slot:header>
        <span class="font-semibold">Edit User</span>
    </x-slot:header>

    <form action="{{ route('admin.users.update', $user) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <label for="name" class="{{ $label }}">Nama <span class="text-red-500">*</span></label>
                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required class="{{ $input }}">
                @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="email" class="{{ $label }}">Email <span class="text-red-500">*</span></label>
                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required class="{{ $input }}">
                @error('email') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="password" class="{{ $label }}">Password</label>
                <input type="password" id="password" name="password" autocomplete="new-password" class="{{ $input }}">
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Kosongkan jika tidak ingin mengubah password.</p>
                @error('password') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="password_confirmation" class="{{ $label }}">Konfirmasi Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" autocomplete="new-password" class="{{ $input }}">
            </div>

            <div>
                <label for="role" class="{{ $label }}">Role</label>
                <select id="role" name="role" class="{{ $input }}">
                    <option value="">— Tanpa role —</option>
                    @foreach ($roles as $nama)
                        <option value="{{ $nama }}" @selected(old('role', $currentRole) === $nama)>{{ $nama }}</option>
                    @endforeach
                </select>
                @error('role') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="mt-6 flex items-center gap-2">
            <button type="submit"
                class="inline-flex items-center gap-1.5 rounded-md bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">
                <i class="bi bi-check-lg"></i> Simpan Perubahan
            </button>
            <a href="{{ route('admin.users.index') }}"
                class="inline-flex items-center rounded-md border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:text-gray-200 dark:hover:bg-gray-700">
                Batal
            </a>
        </div>
    </form>
</x-card>
@endsection
