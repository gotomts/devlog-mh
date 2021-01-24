<div class="form-group member-limitation-list @error($messageProperty) was-validated @enderror">
    <label class="d-block">
        {{ $labelName }}
        @if(isset($required)) <span class="badge badge-danger">必須</span> @endif
    </label>
    @foreach ($checkboxList as $checkbox)
        <div class="form-check form-check-inline">
            <input
                class="form-check-input"
                type="checkbox"
                id="{{ $id . $checkbox->id }}"
                name="{{$name}}"
                value="{{ $checkbox->id }}"
                @foreach ($items as $i => $item)
                    @if ($checkbox->id === $items[$i]->id)
                        checked
                    @endif
                @endforeach
                >
            <label
                class="d-inline-block mb-0"
                for="{{ $id . $checkbox->id }}">
                {{ $checkbox->name }}
            </label>
        </div>
    @endforeach
    @include('admin.components.validate_message', ['property' => $messageProperty ])
</div>
