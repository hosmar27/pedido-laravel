@if ($paginator->hasPages())
    <div class="pagination">
        @if ($paginator->onFirstPage())
            <a style="height: 30px;width:50px" href="#" disabled>&laquo;</a>
        @else
            <a style="height: 30px;width:50px" class="active-page" href="{{ $paginator->previousPageUrl() }}">&laquo;</a>
        @endif

        @foreach ($elements as $element)
            @if (is_string($element))
                a href="">{{ $element }}</a>
            @endif
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <a style="height: 30px;width:50px" class="active-page" href="#">{{ $page }}</a>
                    @else
                    <a style="height: 30px;width:50px" href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <a style="height: 30px;width:50px" href="{{ $paginator->nextPageURL() }}">&raquo;</a>
        @else
            <a style="height: 30px;width:50px" href="#">&raquo;</a>
        @endif
    </div>
@endif