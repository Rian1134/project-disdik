@props([
    'fixed' => false,
])

@php
    $fixedClass = $fixed ? 'fixed top-0 left-0 right-0 z-30' : '';
@endphp

<nav data-navbar
    {{ $attributes->merge(['class' => "bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 {$fixedClass}"]) }}>
    <div class="px-3 sm:px-4">
        <div class="flex items-center justify-between h-14 sm:h-16">
            <!-- Brand -->
            <div class="flex items-center min-w-0 flex-1">
                {{ $brand }}
            </div>

            <!-- Desktop Menu -->
            <div class="hidden lg:flex items-center space-x-4 flex-1 justify-center">
                {{ $menu ?? '' }}
            </div>

            <!-- Actions -->
            <div class="flex items-center space-x-1 sm:space-x-2 shrink-0">
                {{ $actions ?? '' }}
            </div>
        </div>

        <!-- Mobile Menu -->
        <div data-navbar-menu class="hidden lg:hidden py-4 border-t border-gray-200 dark:border-gray-700">
            <div class="flex flex-col space-y-3">
                {{ $menu ?? '' }}
            </div>
        </div>
    </div>
</nav>
