@extends('front.layouts.app')

@section('title'){{ config('titles.front.member.advance_register') }}@endsection

@section('header_js')
@endsection

@section('css')
@endsection

@section('footer_js')
<script src="https://cdn.jsdelivr.net/gh/google/code-prettify@master/loader/run_prettify.js?lang=css&skin=desert">
</script>
@endsection

@section('content')
<h1 class="text-center h2">{{ config('titles.front.member.advance_register') }}</h1>
{{ Form::open(['url' => 'member/advance-register', 'method' => 'POST']) }}
<div class="form-group">
    <label for="inputEmail1">メールアドレスを入力</label>
    <input type="text" class="form-control @error('email') is-invalid @enderror" id="inputEmail1"
        aria-describedby="emailHelp" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
        placeholder="メールアドレス">
    @error('email')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>
<div class="text-center">
    <button class="btn btn-primary" type="submit">送信</button>
</div>
{{ Form::close() }}
@endsection
