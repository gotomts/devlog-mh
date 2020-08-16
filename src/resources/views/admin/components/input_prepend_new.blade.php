<div class="form-group">
    <label
        for="{{ $id }}">{{ $labelName }}
        @if(isset($required)) <span class="badge badge-danger">必須</span> @endif
    </label>
    <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text">{{ $labelName }}</span>
        </div>
        <input
            id="{{ $id }}"
            name="{{ $name }}"
            type="{{ $type }}"
            @if(isset($placeholder)) placeholder="{{ $placeholder }}" @endif
            value="{{ old($name) }}"
            @if(isset($required)) required @endif
            class="form-control @error($name) is-invalid @enderror"
        >
    </div>
    @include('admin.components.validate_message', ['property' => $name])
</div>
