<div class="form-group">
    <label
        for="{{ $id }}">{{ $labelName }}
        @if(isset($required)) <span class="badge badge-danger">必須</span> @endif
    </label>
    <select
        name="{{ $name }}"
        class="form-control @error($name) is-invalid @enderror"
        id="{{ $id }}"
        @if(isset($required)) required @endif
    >
    <option value="" @if ( !old($name) ) selected @endif>選択してください</option>
    @foreach($items as $item)
        <option
            value="{{ $item['key'] }}"
            @if ( old($name) == $item['key'] ) selected @endif
        >
            {{ $item['value'] }}
        </option>
    @endforeach
    </select>
    @include('admin.components.validate_message', ['property' => $name])
</div>
