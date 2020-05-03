<div class="form-group">
    <label
        for="{{ $id }}">{{ $labelName }}
    </label>
    @if(isset($url))
    <figure class="text-center">
        <img class="img-fluid" src="{{ $url }}" alt="{{ $alt }}" title="{{ $title }}">
    </figure>
    @endif
    {{ Form::file("$name", [
        'id' => $id,
        'class' => $class,
    ])}}
    @include('admin.components.upload_validate_message', ['property' => "$name"])
</div>
