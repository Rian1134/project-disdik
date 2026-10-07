{{--
    Komponen: Form Radio
    Fungsi: Satu opsi radio button. Gunakan beberapa dengan 'name' yang sama untuk membentuk grup.

    Props:
    - name    : string wajib
    - value   : string wajib, nilai opsi ini
    - label   : string (opsional)
    - checked : boolean, terpilih secara default
    - disabled: boolean

    Contoh:
    <x-form.radio name="gender" value="L" label="Laki-laki" checked />
    <x-form.radio name="gender" value="P" label="Perempuan" />
--}}
@props([
    'name',
    'value',
    'label' => null,
    'checked' => false,
    'disabled' => false,
])

@php
    $isChecked = old($name, $checked ? $value : null) == $value;
@endphp

<label class="inline-flex items-center gap-2 cursor-pointer {{ $disabled ? 'opacity-60 cursor-not-allowed' : '' }}">
    <input
        type="radio"
        name="{{ $name }}"
        value="{{ $value }}"
        {{ $isChecked ? 'checked' : '' }}
        {{ $disabled ? 'disabled' : '' }}
        {{ $attributes->class([
            'h-4 w-4 border-gray-300 text-blue-600 shadow-sm transition-colors',
            'focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-900/40 dark:border-gray-600 dark:bg-gray-700',
        ]) }}
    />
    @if($label)
        <span class="text-sm text-gray-700 dark:text-gray-300">{{ $label }}</span>
    @endif
</label>
