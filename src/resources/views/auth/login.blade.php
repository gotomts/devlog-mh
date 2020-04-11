@extends('layouts.app')

@section('title'){{ config('titles.login.top') }}@endsection

@section('header_js')
@endsection

@section('css')
@endsection

@section('footer_js')
@endsection

@section('content')
    <div class="flex-body">
        <div class="form-signin">
            <h1 class="text-center">{{ config('titles.login.top') }}</h1>
            {{ Form::open(['url' => 'admin', 'method' => 'POST']) }}
            <div class="form-group">
                <label for="inputEmail1">メールアドレス</label>
                <input type="text" class="form-control @error('email') is-invalid @enderror" id="inputEmail1"
                    aria-describedby="emailHelp" name="email" value="{{ old('email') }}" required
                    autocomplete="email" autofocus placeholder="メールアドレス">
                @error('email')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="inputPassword1">パスワード</label>
                <input type="password" class="form-control mb-1 @error('password') is-invalid @enderror"
                    id="inputPassword1" aria-describedby="passwordHelp" name="password" required
                    autocomplete="current-password" placeholder="パスワード">
                @error('password')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                @if (Route::has('password.request'))
                    <a class="btn-link" href="{{ route('password.request') }}">
                        {{ __('パスワードを忘れた方はこちら') }}
                    </a>
                @endif
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember"
                        id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="remember">
                        {{ __('Remember Me') }}
                    </label>
                </div>
            </div>
            <div class="text-center">
                <button class="btn btn-primary" type="submit">ログイン</button>
            </div>
            {{ Form::close() }}
        </div>
    </div>
@endsection
