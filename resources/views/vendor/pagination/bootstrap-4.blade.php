@if ($paginator->hasPages())
    <ul class="pagination justify-content-end pg-dark mb-0" role="navigation">
        @if ($paginator->onFirstPage())
            <li class="page-item disabled" aria-disabled="true" aria-label="Vorherige Seite">
                <span class="page-link" aria-hidden="true"><i class="fas fa-arrow-left" aria-hidden="true"></i></span>
            </li>
        @else
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="Vorherige Seite"><i class="fas fa-arrow-left" aria-hidden="true"></i></a>
            </li>
        @endif
        @foreach ($elements as $element)
            @if (is_string($element))
                <li class="page-item disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
            @endif
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="page-item active" aria-current="page"><span class="page-link">{{ $page }} <span class="sr-only">(aktuell)</span></span></li>
                    @else
                        <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach
        @if ($paginator->hasMorePages())
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="Nächste Seite"><i class="fas fa-arrow-right" aria-hidden="true"></i></a>
            </li>
        @else
            <li class="page-item disabled" aria-disabled="true" aria-label="Nächste Seite">
                <span class="page-link" aria-hidden="true"><i class="fas fa-arrow-right" aria-hidden="true"></i></span>
            </li>
        @endif
    </ul>
@endif
