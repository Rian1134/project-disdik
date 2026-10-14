@extends('layouts.user')

@section('title', 'Profil Saya')

@section('content')
    <div
        class="mx-auto w-full max-w-xl rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900">

        <div class="mb-6 flex items-center gap-4">
            @if ($user->logo_url)
                <img src="{{ $user->logo_url }}" alt="Logo {{ $user->name }}"
                    class="h-24 w-24 shrink-0 rounded-full border border-gray-200 object-cover dark:border-gray-700">
            @else
                <div
                    class="flex h-24 w-24 shrink-0 items-center justify-center rounded-full bg-emerald-100 text-3xl text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-300">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
            @endif

            <div class="min-w-0">
                <h1 class="truncate text-xl font-semibold text-gray-800 dark:text-gray-100">{{ $user->name }}</h1>
                <p class="truncate text-sm text-gray-500 dark:text-gray-400">{{ $user->email }}</p>
            </div>
        </div>

        <dl class="divide-y divide-gray-100 text-sm dark:divide-gray-800">
            <div class="flex justify-between py-2">
                <dt class="text-gray-500 dark:text-gray-400">Role</dt>
                <dd>{{ $user->getRoleNames()->first() ?? '-' }}</dd>
            </div>
            <div class="flex justify-between py-2">
                <dt class="text-gray-500 dark:text-gray-400">Bergabung sejak</dt>
                <dd>{{ $user->created_at->translatedFormat('d F Y') }}</dd>
            </div>
        </dl>

        <a href="{{ route('user.profile.edit') }}"
            class="mt-6 inline-block rounded-lg bg-emerald-600 px-4 py-2 text-sm text-white hover:bg-emerald-700">
            <i class="bi bi-pencil-square me-1"></i> Edit Profil
        </a>
    </div>
@endsection
