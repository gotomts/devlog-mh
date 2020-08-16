<div class="form-group">
    <label
        for="{{ $id }}">{{ $labelName }}
        @if(isset($required)) <span class="badge badge-danger">必須</span> @endif
    </label>
    <textarea
        id="{{ $id }}"
        name="{{ $name }}"
        rows="{{ $rows }}"
        @if(isset($placeholder)) placeholder="{{ $placeholder }}" @endif
        class="form-control @error($name) is-invalid @enderror"
        @if(isset($required)) required @endif
    >
    </textarea>
    @include('admin.components.validate_message', ['property' => $name])
</div>
