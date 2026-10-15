@extends('layouts.user')

@section('title', 'Profil Saya')

@section('content')
    @php
        $role = $user->getRoleNames()->first();

        // [ikon, label, nilai, warna ubin ikon]
        $info = [
            ['bi-envelope', 'Email', $user->email, 'bg-sky-50 text-sky-600 dark:bg-sky-500/15 dark:text-sky-300'],
            [
                'bi-shield-check',
                'Role',
                $role ?? '-',
                'bg-violet-50 text-violet-600 dark:bg-violet-500/15 dark:text-violet-300',
            ],
            [
                'bi-calendar-check',
                'Bergabung sejak',
                $user->created_at->translatedFormat('d F Y'),
                'bg-amber-50 text-amber-600 dark:bg-amber-500/15 dark:text-amber-300',
            ],
        ];
    @endphp

    <div
        class="mx-auto w-full max-w-2xl overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">

        {{-- Header: avatar + nama --}}
        <div
            class="flex flex-col items-center gap-4 bg-linear-to-r from-emerald-50 via-white to-sky-50 p-6 text-center dark:from-emerald-500/10 dark:via-gray-900 dark:to-sky-500/10 sm:flex-row sm:text-left">
            @if ($user->logo_url)
                <img src="{{ $user->logo_url }}" alt="Logo {{ $user->name }}"
                    class="h-24 w-24 shrink-0 rounded-full border-2 border-white object-cover shadow-md ring-2 ring-emerald-500/40 dark:border-gray-900">
            @else
                <div
                    class="flex h-24 w-24 shrink-0 items-center justify-center rounded-full bg-emerald-100 text-3xl font-semibold text-emerald-700 shadow-md ring-2 ring-emerald-500/40 dark:bg-emerald-500/15 dark:text-emerald-300">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
            @endif

            <div class="min-w-0">
                <h1 class="wrap-break-word text-xl font-semibold text-gray-800 dark:text-gray-100">{{ $user->name }}</h1>
                @if ($role)
                    <div class="mt-2"><x-badge variant="success" pill>{{ $role }}</x-badge></div>
                @endif
            </div>
        </div>

        {{-- Informasi akun --}}
        <dl class="divide-y divide-gray-100 px-6 text-sm dark:divide-gray-800">
            @foreach ($info as [$ikon, $label, $nilai, $warna])
                <div class="flex items-center gap-3 py-3">
                    <span class="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-lg {{ $warna }}">
                        <i class="bi {{ $ikon }}"></i>
                    </span>
                    <div class="min-w-0">
                        <dt class="text-xs text-gray-500 dark:text-gray-400">{{ $label }}</dt>
                        <dd class="wrap-break-word font-medium">{{ $nilai }}</dd>
                    </div>
                </div>
            @endforeach
        </dl>

        <div class="border-t border-gray-100 p-6 dark:border-gray-800">
            <a href="{{ route('user.profile.edit') }}"
                class="inline-flex w-full items-center justify-center rounded-lg bg-emerald-600 px-4 py-2 text-sm text-white hover:bg-emerald-700 sm:w-auto">
                <i class="bi bi-pencil-square me-1"></i> Edit Profil
            </a>
        </div>
    </div>
@endsection
