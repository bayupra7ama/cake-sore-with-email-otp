@if ($paginator->hasPages())
    <div class="shop__pagination">

        {{-- Previous --}}
        @if ($paginator->onFirstPage())
            <a class="disabled">
                <span class="arrow_carrot-left"></span>
            </a>
        @else
            <a href="{{ $paginator->previousPageUrl() }}">
                <span class="arrow_carrot-left"></span>
            </a>
        @endif

        {{-- Page Numbers --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <a class="disabled">{{ $element }}</a>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <a class="active">{{ $page }}</a>
                    @else
                        <a href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}">
                <span class="arrow_carrot-right"></span>
            </a>
        @else
            <a class="disabled">
                <span class="arrow_carrot-right"></span>
            </a>
        @endif

    </div>
@endif
