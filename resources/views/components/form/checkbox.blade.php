{{--
    Komponen: Form Checkbox
    Fungsi: Checkbox tunggal dengan label.

    Props:
    - name    : string wajib
    - label   : string (opsional)
    - value   : string, nilai saat dicentang (default: "1")
    - checked : boolean, dicentang secara default
    - helper  : string (opsional)
    - disabled: boolean

    Contoh:
    <x-form.checkbox name="setuju" label="Saya menyetujui syarat & ketentuan" required />
--}}
@props([
    'name',
    'label' => null,
    'value' => '1',
    'checked' => false,
    'helper' => null,
    'disabled' => false,
])

@php
    $hasError = $errors->has($name);
    $isChecked = old($name, $checked) == $value || old($name, $checked) === true;
@endphp

<div class="w-full">
    <label class="inline-flex items-start gap-2 cursor-pointer {{ $disabled ? 'opacity-60 cursor-not-allowed' : '' }}">
        <input
            type="checkbox"
            name="{{ $name }}"
            value="{{ $value }}"
            {{ $isChecked ? 'checked' : '' }}
            {{ $disabled ? 'disabled' : '' }}
            {{ $attributes->class([
                'mt-0.5 h-4 w-4 rounded border-gray-300 text-blue-600 shadow-sm transition-colors',
                'focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-900/40 dark:border-gray-600 dark:bg-gray-700',
                'border-red-400' => $hasError,
            ]) }}
        />
        @if($label)
            <span class="text-sm text-gray-700 dark:text-gray-300">{{ $label }}</span>
        @endif
    </label>

    @if($hasError)
        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $errors->first($name) }}</p>
    @elseif($helper)
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ $helper }}</p>
    @endif
</div>
