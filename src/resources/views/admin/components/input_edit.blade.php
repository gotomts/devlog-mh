<input
    name="{{ $name }}"
    class="form-control @error($name) is-invalid @enderror"
    id="{{ $id }}"
    type="{{ $type }}"
    placeholder="{{ $placeholder }}"
    value="{{ $value }}"
    @if(isset($required)) required @endif
>
@include('admin.components.validate_message', ['property' => $name])
