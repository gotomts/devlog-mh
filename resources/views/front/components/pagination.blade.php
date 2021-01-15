@if ($prevLink || $nextLink)
<nav class="row justify-content-between">
    <div class="col-6">
    @if ($prevLink)
        <a href="{{ url($page . '/' . $prevLink->url) }}" class="btn btn-outline-primary">
            <i class="fas fa-chevron-left"></i>
            {{ $prevLink->title }}
        </a>
    @endif
    </div>
    <div class="col-6 text-right">
    @if ($nextLink)
        <a href="{{ url($page . '/' .$nextLink->url) }}" class="btn btn-outline-primary">
            {{ $nextLink->title }}
            <i class="fas fa-chevron-right"></i>
        </a>
    @endif
    </div>
</nav>
@endif
