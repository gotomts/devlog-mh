<div class="form-group member-limitation-list @error($messageProperty) was-validated @enderror">
    <label class="d-block">
        {{ $labelName }}
        @if(isset($required)) <span class="badge badge-danger">必須</span> @endif
    </label>
    @foreach ($items as $item)
        @switch($item->id)
            @case($checked)
                <div class="form-check form-check-inline">
                    <input
                        class="form-check-input"
                        type="checkbox"
                        id="{{ $id . $item->id }}"
                        name="{{$name}}"
                        value="{{ $item->id }}"
                        checked
                    >
                    <label
                        class="d-inline-block mb-0"
                        for="{{ $id . $item->id }}">
                        {{ $item->name }}
                    </label>
                </div>
                @break
            @default
                <div class="form-check form-check-inline">
                    <input
                        class="form-check-input"
                        type="checkbox"
                        id="{{ $id . $item->id }}"
                        name="{{$name}}"
                        value="{{ $item->id }}">
                    <label
                        class="d-inline-block mb-0"
                        for="{{ $id . $item->id }}">
                        {{ $item->name }}
                    </label>
                </div>
                @break
        @endswitch
    @endforeach
    @include('admin.components.validate_message', ['property' => $messageProperty ])
</div>
