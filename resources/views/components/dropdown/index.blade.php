@props([
    'align' => 'left',
    'width' => 'auto',
])

@php
    $alignClasses = [
        'left' => 'left-0',
        'right' => 'right-0',
    ];
    
    $widthClasses = [
        'auto' => 'w-auto',
        'xs' => 'w-32',
        'sm' => 'w-40',
        'md' => 'w-48',
        'lg' => 'w-56',
        'xl' => 'w-64',
    ];
@endphp

<div
    data-dropdown
    data-align="{{ $align }}"
    class="relative inline-block"
>
    <div data-dropdown-trigger>
        {{ $trigger }}
    </div>
    
    <div
        data-dropdown-menu
        class="hidden absolute {{ $alignClasses[$align] ?? 'left-0' }} {{ $widthClasses[$width] ?? 'w-auto' }} mt-2 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 z-50 min-w-40 max-w-[calc(100vw-2rem)] sm:max-w-none"
    >
        <div class="py-1">
            {{ $slot }}
        </div>
    </div>
</div>