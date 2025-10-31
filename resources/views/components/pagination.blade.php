@if ($paginator->hasPages())
    <div class="flex flex-col md:flex-row items-center justify-between w-full space-y-3 md:space-y-0 text-sm text-gray-600">

        {{-- ✅ Showing X–Y of Z summary --}}
        <div class="text-gray-600">
            @php
                $from = ($paginator->currentPage() - 1) * $paginator->perPage() + 1;
                $to = min($paginator->currentPage() * $paginator->perPage(), $paginator->total());
            @endphp
            Showing <span class="font-semibold text-gray-800">{{ $from }}</span>
            –
            <span class="font-semibold text-gray-800">{{ $to }}</span>
            of <span class="font-semibold text-gray-800">{{ $paginator->total() }}</span> invoices
        </div>

        {{-- ✅ Pagination Links --}}
        <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center space-x-2 text-sm">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <span class="px-3 py-2 rounded-lg bg-gray-100 text-gray-400 cursor-not-allowed flex items-center">
                    <i class="fas fa-chevron-left mr-1"></i> Prev
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
                   class="px-3 py-2 rounded-lg bg-white border border-gray-200 text-gray-700 hover:bg-blue-50 hover:text-blue-600 flex items-center transition">
                    <i class="fas fa-chevron-left mr-1"></i> Prev
                </a>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <span class="px-3 py-2 text-gray-400">{{ $element }}</span>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="px-3 py-2 rounded-lg bg-blue-600 text-white font-semibold shadow-sm">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}"
                               class="px-3 py-2 rounded-lg bg-white border border-gray-200 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next"
                   class="px-3 py-2 rounded-lg bg-white border border-gray-200 text-gray-700 hover:bg-blue-50 hover:text-blue-600 flex items-center transition">
                    Next <i class="fas fa-chevron-right ml-1"></i>
                </a>
            @else
                <span class="px-3 py-2 rounded-lg bg-gray-100 text-gray-400 cursor-not-allowed flex items-center">
                    Next <i class="fas fa-chevron-right ml-1"></i>
                </span>
            @endif
        </nav>
    </div>
@endif
