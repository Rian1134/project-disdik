@extends('layouts.admin')

@section('title', 'Detail User')

@section('content')
    <x-breadcrumb :items="[['label' => 'Manajemen User', 'url' => route('admin.users.index')], ['label' => $user->name]]" />

    {{-- ===== Header user ===== --}}
    <x-card>
        <div class="flex flex-col gap-4 border-l-4 border-indigo-500 pl-4 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex min-w-0 items-center gap-3">
                <x-avatar :name="$user->name" size="lg" rounded="md" />
                <div class="min-w-0">
                    <h2 class="truncate text-lg font-bold text-indigo-700 dark:text-indigo-300">{{ $user->name }}</h2>
                    <p class="truncate text-sm text-gray-500 dark:text-gray-400">{{ $user->email }}</p>
                    <div class="mt-1 flex flex-wrap items-center gap-1">
                        @forelse ($user->roles as $role)
                            <span
                                class="inline-flex items-center rounded-full bg-indigo-100 px-2.5 py-0.5 text-xs font-medium text-indigo-700 dark:bg-indigo-500/20 dark:text-indigo-300">{{ $role->name }}</span>
                        @empty
                            <span
                                class="inline-flex items-center rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-medium text-slate-600 dark:bg-slate-500/20 dark:text-slate-300">Tanpa
                                role</span>
                        @endforelse
                        @if ($user->id === auth()->id())
                            <span
                                class="inline-flex items-center rounded-full bg-emerald-100 px-2.5 py-0.5 text-xs font-medium text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-300">Anda</span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="flex gap-2">
                <x-button href="{{ route('admin.users.index') }}" variant="light"
                    class="flex-1 sm:flex-none">Kembali</x-button>
                <x-button href="{{ route('admin.users.edit', $user) }}" class="flex-1 sm:flex-none">
                    <i class="bi bi-pencil-fill me-1"></i> Edit
                </x-button>
            </div>
        </div>
    </x-card>

    {{-- ===== Ringkasan ===== --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
        <x-card>
            <div class="flex items-center gap-3">
                <span
                    class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-lg border border-indigo-200 bg-indigo-100 text-lg text-indigo-600 dark:border-indigo-500/30 dark:bg-indigo-500/20 dark:text-indigo-300">
                    <i class="bi bi-building"></i>
                </span>
                <div class="min-w-0">
                    <p class="truncate text-xs text-gray-500 dark:text-gray-400">Jumlah Sekolah</p>
                    <p class="text-2xl font-bold text-indigo-600 dark:text-indigo-300">{{ $jumlahSekolah }}</p>
                </div>
            </div>
        </x-card>
        <x-card>
            <div class="flex items-center gap-3">
                <span
                    class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-lg border border-emerald-200 bg-emerald-100 text-lg text-emerald-600 dark:border-emerald-500/30 dark:bg-emerald-500/20 dark:text-emerald-300">
                    <i class="bi bi-calendar-plus"></i>
                </span>
                <div class="min-w-0">
                    <p class="truncate text-xs text-gray-500 dark:text-gray-400">Dibuat</p>
                    <p class="truncate text-base font-semibold text-emerald-600 dark:text-emerald-300">
                        {{ $user->created_at?->format('d-m-Y H:i') ?? '-' }}</p>
                </div>
            </div>
        </x-card>
        <x-card>
            <div class="flex items-center gap-3">
                <span
                    class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-lg border border-amber-200 bg-amber-100 text-lg text-amber-600 dark:border-amber-500/30 dark:bg-amber-500/20 dark:text-amber-300">
                    <i class="bi bi-clock-history"></i>
                </span>
                <div class="min-w-0">
                    <p class="truncate text-xs text-gray-500 dark:text-gray-400">Terakhir Diperbarui</p>
                    <p class="truncate text-base font-semibold text-amber-600 dark:text-amber-300">
                        {{ $user->updated_at?->format('d-m-Y H:i') ?? '-' }}</p>
                </div>
            </div>
        </x-card>
    </div>

    {{-- ===== Informasi akun ===== --}}
    <x-card>
        <x-slot:header>
            <span class="font-semibold"><i
                    class="bi bi-person-vcard-fill me-2 text-indigo-600 dark:text-indigo-400"></i>Informasi Akun</span>
        </x-slot:header>

        <dl class="divide-y divide-gray-200 text-sm dark:divide-gray-700">
            <div class="flex justify-between gap-4 py-2">
                <dt class="shrink-0 text-slate-500 dark:text-slate-400">Nama</dt>
                <dd class="min-w-0 break-words text-right font-medium">{{ $user->name }}</dd>
            </div>
            <div class="flex justify-between gap-4 py-2">
                <dt class="shrink-0 text-slate-500 dark:text-slate-400">Email</dt>
                <dd class="min-w-0 break-words text-right font-medium">{{ $user->email }}</dd>
            </div>
            <div class="flex justify-between gap-4 py-2">
                <dt class="shrink-0 text-slate-500 dark:text-slate-400">Role</dt>
                <dd class="min-w-0 text-right font-medium">
                    @forelse ($user->roles as $role)
                        <span
                            class="rounded-full bg-indigo-100 px-2 py-0.5 text-xs font-medium text-indigo-700 dark:bg-indigo-500/20 dark:text-indigo-300">{{ $role->name }}</span>
                    @empty
                        <span class="text-gray-400">Tanpa role</span>
                    @endforelse
                </dd>
            </div>
            <div class="flex justify-between gap-4 py-2">
                <dt class="shrink-0 text-slate-500 dark:text-slate-400">Jumlah Sekolah</dt>
                <dd class="min-w-0 text-right font-medium">{{ $jumlahSekolah }}</dd>
            </div>
        </dl>
    </x-card>
@endsection
