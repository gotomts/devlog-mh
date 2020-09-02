<div class="form-group">
    <label
        for="{{ $id }}">{{ $labelName }}
        @if(isset($required)) <span class="badge badge-danger">必須</span> @endif
    </label>
    <input
        name="{{ $name }}"
        class="form-control @error($name) is-invalid @enderror"
        id="{{ $id }}"
        type="{{ $type }}"
        @if(isset($placeholder)) placeholder="{{ $placeholder }}" @endif
        value="{{ old($name) }}"
        @if(isset($required)) required @endif
    >
    @include('admin.components.validate_message', ['property' => $name])
</div>
