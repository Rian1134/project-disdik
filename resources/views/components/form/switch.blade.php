{{--
    Komponen: Form Switch
    Fungsi: Toggle on/off, alternatif visual dari checkbox.

    Props:
    - name    : string wajib
    - label   : string (opsional)
    - value   : string, nilai saat aktif (default: "1")
    - checked : boolean, aktif secara default
    - disabled: boolean

    Contoh:
    <x-form.switch name="notifikasi" label="Aktifkan Notifikasi" checked />
--}}
@props([
    'name',
    'label' => null,
    'value' => '1',
    'checked' => false,
    'disabled' => false,
])

@php
    $isChecked = old($name, $checked) == $value || old($name, $checked) === true;
@endphp

<label class="inline-flex items-center gap-3 cursor-pointer {{ $disabled ? 'opacity-60 cursor-not-allowed' : '' }}">
    <span class="relative inline-flex items-center">
        <input
            type="checkbox"
            name="{{ $name }}"
            value="{{ $value }}"
            {{ $isChecked ? 'checked' : '' }}
            {{ $disabled ? 'disabled' : '' }}
            {{ $attributes->class(['peer sr-only']) }}
        />
        <span class="h-6 w-11 rounded-full bg-gray-300 peer-checked:bg-blue-600 transition-colors duration-200 dark:bg-gray-600"></span>
        <span class="absolute left-1 top-1 h-4 w-4 rounded-full bg-white shadow transition-transform duration-200 peer-checked:translate-x-5"></span>
    </span>
    @if($label)
        <span class="text-sm text-gray-700 dark:text-gray-300">{{ $label }}</span>
    @endif
</label>
