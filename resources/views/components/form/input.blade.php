{{--
    Komponen: Form Input
    Fungsi: Input teks dengan label, helper text, dan validasi error otomatis.

    Props:
    - name    : string wajib, nama field (dipakai untuk old(), $errors, dan id)
    - label   : string, teks label (opsional)
    - type    : text | email | password | number | date | dst (default: text)
    - helper  : string, teks bantuan di bawah input (opsional)
    - prefix  : slot, elemen/teks di kiri input (opsional)
    - suffix  : slot, elemen/teks di kanan input (opsional)
    - required: boolean
    - disabled: boolean
    - readonly: boolean

    Error validasi otomatis diambil dari $errors->first($name) (standar Laravel).

    Contoh:
    <x-form.input name="email" label="Email" type="email" required placeholder="nama@email.com" />
    <x-form.input name="harga" label="Harga" helper="Masukkan tanpa titik" >
        <x-slot:prefix>Rp</x-slot:prefix>
    </x-form.input>
--}}
@props([
    'name',
    'label' => null,
    'type' => 'text',
    'helper' => null,
    'required' => false,
    'disabled' => false,
    'readonly' => false,
])

@php
    $hasError = $errors->has($name);
    $value = old($name, $attributes->get('value'));
@endphp

<div class="w-full">
    @if($label)
        <label for="{{ $name }}" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">
            {{ $label }} @if($required)<span class="text-red-500">*</span>@endif
        </label>
    @endif

    <div class="flex rounded-lg shadow-sm">
        @isset($prefix)
            <span class="inline-flex items-center rounded-l-lg border border-r-0 border-gray-300 bg-gray-50 px-3 text-sm text-gray-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-400">
                {{ $prefix }}
            </span>
        @endisset

        <input
            type="{{ $type }}"
            name="{{ $name }}"
            id="{{ $name }}"
            @if($value !== null) value="{{ $value }}" @endif
            {{ $required ? 'required' : '' }}
            {{ $disabled ? 'disabled' : '' }}
            {{ $readonly ? 'readonly' : '' }}
            {{ $attributes->except('value')->class([
                'w-full min-w-0 flex-1 border px-3 py-2 text-sm text-gray-900 placeholder-gray-400 shadow-sm transition-colors',
                'focus:outline-none focus:ring-2 focus:ring-offset-0',
                'disabled:bg-gray-100 disabled:cursor-not-allowed dark:disabled:bg-gray-900',
                'dark:bg-gray-800 dark:text-gray-100 dark:placeholder-gray-500',
                'rounded-l-lg' => !isset($prefix),
                'rounded-r-lg' => !isset($suffix),
                'border-red-400 focus:border-red-500 focus:ring-red-200 dark:border-red-500' => $hasError,
                'border-gray-300 focus:border-blue-500 focus:ring-blue-100 dark:border-gray-600 dark:focus:ring-blue-900/40' => !$hasError,
            ]) }}
        />

        @isset($suffix)
            <span class="inline-flex items-center rounded-r-lg border border-l-0 border-gray-300 bg-gray-50 px-3 text-sm text-gray-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-400">
                {{ $suffix }}
            </span>
        @endisset
    </div>

    @if($hasError)
        <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $errors->first($name) }}</p>
    @elseif($helper)
        <p class="mt-1.5 text-sm text-gray-500 dark:text-gray-400">{{ $helper }}</p>
    @endif
</div>
