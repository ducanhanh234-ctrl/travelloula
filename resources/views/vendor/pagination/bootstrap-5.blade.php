@if ($paginator->hasPages())
    <nav class="d-flex justify-items-center justify-content-between">

        {{-- Mobile --}}
        <div class="d-flex justify-content-between flex-fill d-sm-none">
            <ul class="pagination">

                {{-- Trang trước --}}
                @if ($paginator->onFirstPage())
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link">Trang trước</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">
                            Trang trước
                        </a>
                    </li>
                @endif

                {{-- Trang sau --}}
                @if ($paginator->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">
                            Trang sau
                        </a>
                    </li>
                @else
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link">Trang sau</span>
                    </li>
                @endif

            </ul>
        </div>

        {{-- Desktop --}}
        <div class="d-none flex-sm-fill d-sm-flex align-items-sm-center justify-content-sm-between">

            {{-- <div>
                <p class="small text-muted mb-0">
                    Hiển thị
                    <span class="fw-semibold">{{ $paginator->firstItem() }}</span>
                    đến
                    <span class="fw-semibold">{{ $paginator->lastItem() }}</span>
                    của
                    <span class="fw-semibold">{{ $paginator->total() }}</span>
                    lịch khởi hành
                </p>
            </div> --}}

            <div>
                <ul class="pagination mb-0">

                    {{-- Trang trước --}}
                    @if ($paginator->onFirstPage())
                        <li class="page-item disabled" aria-disabled="true">
                            <span class="page-link">‹</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev"
                                title="Trang trước">
                                ‹
                            </a>
                        </li>
                    @endif

                    {{-- Số trang --}}
                    @foreach ($elements as $element)
                        @if (is_string($element))
                            <li class="page-item disabled">
                                <span class="page-link">
                                    {{ $element }}
                                </span>
                            </li>
                        @endif

                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <li class="page-item active">
                                        <span class="page-link">
                                            {{ $page }}
                                        </span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $url }}">
                                            {{ $page }}
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Trang sau --}}
                    @if ($paginator->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next"
                                title="Trang sau">
                                ›
                            </a>
                        </li>
                    @else
                        <li class="page-item disabled">
                            <span class="page-link">›</span>
                        </li>
                    @endif

                </ul>
            </div>

        </div>
    </nav>
@endif
