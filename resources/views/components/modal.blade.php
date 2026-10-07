@props([
    'id' => null,
    'size' => 'md',
    'centered' => false,
    'scrollable' => false,
])

@php
    $sizes = [
        'sm' => 'max-w-sm',
        'md' => 'max-w-md',
        'lg' => 'max-w-lg',
        'xl' => 'max-w-xl',
        '2xl' => 'max-w-2xl',
        '3xl' => 'max-w-3xl',
        '4xl' => 'max-w-4xl',
        '5xl' => 'max-w-5xl',
    ];
    
    $sizeClass = $sizes[$size] ?? $sizes['md'];
    $centeredClass = $centered ? 'items-center' : 'items-start';
    $scrollableClass = $scrollable ? 'max-h-[90vh]' : '';
@endphp

<div
    id="{{ $id }}"
    data-modal
    class="hidden fixed inset-0 z-99999 overflow-y-auto"
    role="dialog"
    aria-modal="true"
>
    <div class="flex {{ $centeredClass }} justify-center min-h-screen p-3 sm:p-4">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-gray-900/50 transition-opacity" data-modal-close></div>
        
        <!-- Modal Content -->
        <div
            data-modal-content
            class="relative w-full {{ $sizeClass }} {{ $scrollableClass }} overflow-y-auto bg-white dark:bg-gray-800 rounded-lg shadow-xl transform transition-all my-4 sm:my-8 mx-auto border border-gray-200 dark:border-gray-700"
        >
            @isset($header)
                <div class="flex items-center justify-between p-3 sm:p-4 border-b border-gray-200 dark:border-gray-700 rounded-t-lg">
                    <div class="flex-1 min-w-0">
                        {{ $header }}
                    </div>
                    <button
                        type="button"
                        data-modal-close
                        class="shrink-0 ml-2 text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors rounded-md p-1 hover:bg-gray-100 dark:hover:bg-gray-700"
                        aria-label="Close modal"
                    >
                        <i class="bi bi-x-lg text-xl"></i>
                    </button>
                </div>
            @else
                <div class="flex items-center justify-end p-3 sm:p-4 border-b border-gray-200 dark:border-gray-700 rounded-t-lg">
                    <button
                        type="button"
                        data-modal-close
                        class="text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors rounded-md p-1 hover:bg-gray-100 dark:hover:bg-gray-700"
                        aria-label="Close modal"
                    >
                        <i class="bi bi-x-lg text-xl"></i>
                    </button>
                </div>
            @endisset
            
            <div class="p-3 sm:p-4 md:p-5 text-gray-700 dark:text-gray-300">
                {{ $slot }}
            </div>
            
            @isset($footer)
                <div class="flex flex-wrap items-center justify-end gap-2 p-3 sm:p-4 border-t border-gray-200 dark:border-gray-700 rounded-b-lg bg-gray-50 dark:bg-gray-900/40">
                    {{ $footer }}
                </div>
            @endisset
        </div>
    </div>
</div>