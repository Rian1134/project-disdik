{{--
    Komponen: Form Textarea
    Fungsi: Input teks multi-baris dengan label, helper text, dan validasi error.

    Props:
    - name    : string wajib
    - label   : string (opsional)
    - rows    : integer (default: 4)
    - helper  : string (opsional)
    - required: boolean
    - disabled: boolean

    Contoh:
    <x-form.textarea name="deskripsi" label="Deskripsi" rows="5" placeholder="Tulis deskripsi..." />
--}}
@props([
    'name',
    'label' => null,
    'rows' => 4,
    'helper' => null,
    'required' => false,
    'disabled' => false,
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

    <textarea
        name="{{ $name }}"
        id="{{ $name }}"
        rows="{{ $rows }}"
        {{ $required ? 'required' : '' }}
        {{ $disabled ? 'disabled' : '' }}
        {{ $attributes->except('value')->class([
            'w-full rounded-lg border px-3 py-2 text-sm text-gray-900 placeholder-gray-400 shadow-sm transition-colors',
            'focus:outline-none focus:ring-2',
            'disabled:bg-gray-100 disabled:cursor-not-allowed dark:disabled:bg-gray-900',
            'dark:bg-gray-800 dark:text-gray-100 dark:placeholder-gray-500',
            'border-red-400 focus:border-red-500 focus:ring-red-200 dark:border-red-500' => $hasError,
            'border-gray-300 focus:border-blue-500 focus:ring-blue-100 dark:border-gray-600 dark:focus:ring-blue-900/40' => !$hasError,
        ]) }}
    >{{ $value }}</textarea>

    @if($hasError)
        <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $errors->first($name) }}</p>
    @elseif($helper)
        <p class="mt-1.5 text-sm text-gray-500 dark:text-gray-400">{{ $helper }}</p>
    @endif
</div>
