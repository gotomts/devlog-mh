@if (session('success'))
    <div class="pt-5">
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    </div>
@endif

@if (session('error'))
    <div class="pt-5">
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    </div>
@endif
