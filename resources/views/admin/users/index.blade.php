@extends('layouts.admin')

@section('title', 'Manajemen User')

@section('content')
<x-card>
    <x-slot:header>
        <div class="flex flex-wrap items-center justify-between gap-2">
            <span class="font-semibold">List User</span>
            <a href="{{ route('admin.users.create') }}"
                class="inline-flex items-center gap-1.5 rounded-md bg-blue-600 px-3 py-1.5 text-sm font-medium text-white hover:bg-blue-700">
                <i class="bi bi-plus-lg"></i> Tambah User
            </a>
        </div>
    </x-slot:header>

    <form method="GET" action="{{ route('admin.users.index') }}" class="mb-4 flex gap-2">
        <input type="search" name="q" value="{{ $q }}" placeholder="Cari nama atau email..."
            class="w-full max-w-sm rounded-md border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100">
        <button type="submit"
            class="inline-flex items-center gap-1.5 rounded-md border border-gray-300 px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:text-gray-200 dark:hover:bg-gray-700">
            <i class="bi bi-search"></i> Cari
        </button>
        @if ($q !== '')
            <a href="{{ route('admin.users.index') }}"
                class="inline-flex items-center rounded-md px-3 py-2 text-sm text-gray-500 hover:underline">Reset</a>
        @endif
    </form>

    <x-table striped hover bordered class="text-sm">
        <x-slot:head>
            <tr class="bg-gray-100 dark:bg-gray-700">
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
                        <span class="font-medium">{{ $user->name }}</span>
                        @if ($user->id === auth()->id())
                            <span class="rounded-full bg-blue-100 px-2 py-0.5 text-[11px] font-medium text-blue-700 dark:bg-blue-900 dark:text-blue-200">Anda</span>
                        @endif
                    </div>
                </x-table.cell>
                <x-table.cell>{{ $user->email }}</x-table.cell>
                <x-table.cell>
                    @forelse ($user->roles as $role)
                        <span class="rounded-full bg-gray-100 px-2 py-0.5 text-xs font-medium dark:bg-gray-700">{{ $role->name }}</span>
                    @empty
                        <span class="text-gray-400">-</span>
                    @endforelse
                </x-table.cell>
                <x-table.cell class="whitespace-nowrap text-center">
                    <a href="{{ route('admin.users.show', $user) }}" title="Detail"
                        class="inline-flex items-center rounded-md bg-gray-100 px-2 py-1 text-gray-700 hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600">
                        <i class="bi bi-eye"></i>
                    </a>
                    <a href="{{ route('admin.users.edit', $user) }}" title="Edit"
                        class="inline-flex items-center rounded-md bg-amber-100 px-2 py-1 text-amber-700 hover:bg-amber-200">
                        <i class="bi bi-pencil-square"></i>
                    </a>
                    @if ($user->id !== auth()->id())
                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline"
                            onsubmit="return confirm(@js('Hapus user ' . $user->name . '?'))">
                            @csrf
                            @method('DELETE')
                            <button type="submit" title="Hapus"
                                class="inline-flex items-center rounded-md bg-red-100 px-2 py-1 text-red-700 hover:bg-red-200">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    @endif
                </x-table.cell>
            </x-table.row>
        @empty
            <x-table.empty colspan="5" />
        @endforelse
    </x-table>

    <x-pagination :paginator="$users" class="mt-4" />
</x-card>
@endsection
