@extends('layouts.admin')

@section('title', 'Detail User')

@section('content')
<x-card>
    <x-slot:header>
        <div class="flex items-center justify-between gap-2">
            <span class="font-semibold">Detail User</span>
            <a href="{{ route('admin.users.index') }}"
                class="text-sm text-gray-600 hover:underline dark:text-gray-300">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </x-slot:header>

    <div class="mb-6 flex items-center gap-3">
        <x-avatar :name="$user->name" size="md" />
        <div class="min-w-0">
            <p class="truncate text-base font-semibold text-gray-800 dark:text-gray-100">{{ $user->name }}</p>
            <p class="truncate text-sm text-gray-500 dark:text-gray-400">{{ $user->email }}</p>
        </div>
    </div>

    <dl class="grid gap-x-6 gap-y-4 text-sm sm:grid-cols-2">
        <div>
            <dt class="text-gray-500 dark:text-gray-400">Role</dt>
            <dd class="mt-1 text-gray-800 dark:text-gray-100">
                @forelse ($user->roles as $role)
                    <span class="rounded-full bg-gray-100 px-2 py-0.5 text-xs font-medium dark:bg-gray-700">{{ $role->name }}</span>
                @empty
                    <span class="text-gray-400">Tanpa role</span>
                @endforelse
            </dd>
        </div>
        <div>
            <dt class="text-gray-500 dark:text-gray-400">Jumlah Sekolah</dt>
            <dd class="mt-1 text-gray-800 dark:text-gray-100">{{ $jumlahSekolah }}</dd>
        </div>
        <div>
            <dt class="text-gray-500 dark:text-gray-400">Dibuat</dt>
            <dd class="mt-1 text-gray-800 dark:text-gray-100">{{ $user->created_at?->format('d-m-Y H:i') }}</dd>
        </div>
        <div>
            <dt class="text-gray-500 dark:text-gray-400">Terakhir Diperbarui</dt>
            <dd class="mt-1 text-gray-800 dark:text-gray-100">{{ $user->updated_at?->format('d-m-Y H:i') }}</dd>
        </div>
    </dl>

    <div class="mt-6">
        <a href="{{ route('admin.users.edit', $user) }}"
            class="inline-flex items-center gap-1.5 rounded-md bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">
            <i class="bi bi-pencil-square"></i> Edit
        </a>
    </div>
</x-card>
@endsection
