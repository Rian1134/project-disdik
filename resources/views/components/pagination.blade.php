{{--
    Komponen: Pagination
    Fungsi: Navigasi halaman untuk data yang dipaginasi (Laravel Paginator).

    Props:
    - paginator : instance Illuminate\Pagination\LengthAwarePaginator (wajib)

    Contoh:
    di controller: $users = User::paginate(10);
    <x-pagination :paginator="$users" />
--}}
@props([
    'paginator',
])

@if($paginator->hasPages())
<nav class="flex flex-wrap items-center justify-between gap-3" role="navigation" aria-label="Pagination">
    <p class="text-sm text-gray-600 dark:text-gray-400">
        Menampilkan <span class="font-medium">{{ $paginator->firstItem() }}</span>
        - <span class="font-medium">{{ $paginator->lastItem() }}</span>
        dari <span class="font-medium">{{ $paginator->total() }}</span> data
    </p>

    <ul class="flex flex-wrap items-center gap-1">
        {{-- Previous --}}
        <li>
            @if($paginator->onFirstPage())
                <span class="inline-flex h-9 w-9 items-center justify-center rounded-md text-gray-300 dark:text-gray-600 cursor-not-allowed">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" /></svg>
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="inline-flex h-9 w-9 items-center justify-center rounded-md text-gray-600 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700 transition-colors">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" /></svg>
                </a>
            @endif
        </li>

        {{-- Page numbers --}}
        @foreach($paginator->getUrlRange(max(1, $paginator->currentPage() - 2), min($paginator->lastPage(), $paginator->currentPage() + 2)) as $page => $url)
            <li>
                @if($page == $paginator->currentPage())
                    <span class="inline-flex h-9 w-9 items-center justify-center rounded-md bg-blue-600 text-sm font-medium text-white">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" class="inline-flex h-9 w-9 items-center justify-center rounded-md text-sm text-gray-600 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700 transition-colors">{{ $page }}</a>
                @endif
            </li>
        @endforeach

        {{-- Next --}}
        <li>
            @if($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="inline-flex h-9 w-9 items-center justify-center rounded-md text-gray-600 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700 transition-colors">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" /></svg>
                </a>
            @else
                <span class="inline-flex h-9 w-9 items-center justify-center rounded-md text-gray-300 dark:text-gray-600 cursor-not-allowed">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" /></svg>
                </span>
            @endif
        </li>
    </ul>
</nav>
@endif