@extends('front.layouts.app')

@section('title'){{ config('titles.front.member.login') }}@endsection

@section('header_js')
@endsection

@section('css')
@endsection

@section('footer_js')
<script src="https://cdn.jsdelivr.net/gh/google/code-prettify@master/loader/run_prettify.js?lang=css&skin=desert">
</script>
@endsection

@section('content')
<div class="container container-sm">
    <h1 class="text-center h2">ログイン</h1>
    {{ Form::open(['url' => 'member', 'method' => 'POST']) }}
    <div class="form-group">
        <label for="inputEmail1">メールアドレス</label>
        <input type="text" class="form-control @error('email') is-invalid @enderror" id="inputEmail1"
            aria-describedby="emailHelp" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
            placeholder="メールアドレス">
        @error('email')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <div class="form-group mb-4">
        <label for="inputPassword1">パスワード</label>
        <input type="password" class="form-control mb-1 @error('password') is-invalid @enderror" id="inputPassword1"
            aria-describedby="passwordHelp" name="password" required autocomplete="current-password"
            placeholder="パスワード">
        @error('password')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <div class="text-center">
        <button class="btn btn-primary" type="submit">ログイン</button>
    </div>
    {{ Form::close() }}
</div>
@endsection
