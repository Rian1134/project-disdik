{{--
    Komponen: Form Select
    Fungsi: Dropdown pilihan native dengan label dan validasi error.

    Props:
    - name        : string wajib
    - label       : string (opsional)
    - options     : array asosiatif ['value' => 'Label', ...] ATAU array biasa
    - placeholder : string, opsi kosong pertama (opsional, misal "Pilih salah satu")
    - helper      : string (opsional)
    - required    : boolean
    - disabled    : boolean

    Contoh:
    <x-form.select
        name="kota"
        label="Kota"
        placeholder="Pilih kota"
        :options="['jkt' => 'Jakarta', 'bdg' => 'Bandung', 'sby' => 'Surabaya']"
    />
--}}
@props([
    'name',
    'label' => null,
    'options' => [],
    'placeholder' => null,
    'helper' => null,
    'required' => false,
    'disabled' => false,
])

@php
    $hasError = $errors->has($name);
    $selected = old($name, $attributes->get('value'));
@endphp

<div class="w-full">
    @if($label)
        <label for="{{ $name }}" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">
            {{ $label }} @if($required)<span class="text-red-500">*</span>@endif
        </label>
    @endif

    <select
        name="{{ $name }}"
        id="{{ $name }}"
        {{ $required ? 'required' : '' }}
        {{ $disabled ? 'disabled' : '' }}
        {{ $attributes->except('value')->class([
            'w-full rounded-lg border px-3 py-2 text-sm text-gray-900 shadow-sm transition-colors',
            'focus:outline-none focus:ring-2',
            'disabled:bg-gray-100 disabled:cursor-not-allowed dark:disabled:bg-gray-900',
            'dark:bg-gray-800 dark:text-gray-100',
            'border-red-400 focus:border-red-500 focus:ring-red-200 dark:border-red-500' => $hasError,
            'border-gray-300 focus:border-blue-500 focus:ring-blue-100 dark:border-gray-600 dark:focus:ring-blue-900/40' => !$hasError,
        ]) }}
    >
        @if($placeholder)
            <option value="" {{ !$selected ? 'selected' : '' }}>{{ $placeholder }}</option>
        @endif

        @foreach($options as $optValue => $optLabel)
            <option value="{{ $optValue }}" {{ (string) $selected === (string) $optValue ? 'selected' : '' }}>
                {{ $optLabel }}
            </option>
        @endforeach
    </select>

    @if($hasError)
        <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $errors->first($name) }}</p>
    @elseif($helper)
        <p class="mt-1.5 text-sm text-gray-500 dark:text-gray-400">{{ $helper }}</p>
    @endif
</div>
