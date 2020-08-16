@if (count($property) !== 0)
<div class="d-flex justify-content-center">
    {{ $property->links() }}
</div>
@endif
