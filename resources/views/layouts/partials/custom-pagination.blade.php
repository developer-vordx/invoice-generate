@if($customers instanceof \Illuminate\Pagination\LengthAwarePaginator)
    @php
        $elements = $customers->elements();
    @endphp

    @if ($customers->hasPages())
        <nav class="mt-6 flex justify-center items-center space-x-1" role="navigation" aria-label="Pagination">
            {{-- Previous Page Link --}}
            @if ($customers->onFirstPage())
                <span class="px-4 py-2 rounded-lg bg-gray-200 text-gray-500 cursor-not-allowed">&laquo;</span>
            @else
                <a href="{{ $customers->previousPageUrl() }}" class="px-4 py-2 rounded-lg bg-primary text-white hover:bg-blue-700 transition">&laquo;</a>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <span class="px-4 py-2 rounded-lg bg-gray-200 text-gray-500">{{ $element }}</span>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $customers->currentPage())
                            <span class="px-4 py-2 rounded-lg bg-primary text-white font-semibold">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="px-4 py-2 rounded-lg bg-gray-100 text-gray-700 hover:bg-primary hover:text-white transition">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($customers->hasMorePages())
                <a href="{{ $customers->nextPageUrl() }}" class="px-4 py-2 rounded-lg bg-primary text-white hover:bg-blue-700 transition">&raquo;</a>
            @else
                <span class="px-4 py-2 rounded-lg bg-gray-200 text-gray-500 cursor-not-allowed">&raquo;</span>
            @endif
        </nav>
    @endif
@endif
