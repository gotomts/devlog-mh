@extends('layouts.app')

@section('title'){{ config('titles.user.create') }}@endsection

@section('header_js')
@endsection

@section('css')
@endsection

@section('footer_js')
@endsection

@section('content')
    <div class="container mb-5">
        <div class="page-title">
            <a href="{{ url('mh-login/user') }}" class="d-block"><i class="fas fa-chevron-circle-left"></i> 前のページへ戻る</a>
            <h1 class="d-inline-block mb-0 mr-2 align-middle">{{ config('titles.user.create') }}</h1>
        </div>
        {{ Form::open(['url' => 'mh-login/user/create', 'method' => 'POST']) }}
        <div class="form-group">
            <label for="inputName1">ユーザー名 <span class="badge badge-danger">必須</span></label>
            <input name="name" class="form-control @error('name') is-invalid @enderror" id="inputName1" type="text" aria-describedby="nameHelp" placeholder="ユーザー名" value="{{ old('name') }}" required>
            @error('name')
            <div class="invalid-feedback">
                <div class="text-danger">{{ $message }}</div>
            </div>
            @enderror
        </div>
        <div class="form-group">
            <label for="inputEmail1">メールアドレス <span class="badge badge-danger">必須</span></label>
            <input name="email" class="form-control @error('email') is-invalid @enderror" id="inputEmail1" type="text" aria-describedby="emailHelp" placeholder="メールアドレス" value="{{ old('email') }}" required>
            @error('email')
            <div class="invalid-feedback">
                <div class="text-danger">{{ $message }}</div>
            </div>
            @enderror
        </div>
        <div class="form-group">
            <label for="inputRole1">ユーザー権限 <span class="badge badge-danger">必須</span></label>
            <select name="role" class="form-control @error('role') is-invalid @enderror" id="inputRole1" aria-describedby="roleHelp" required>
                    <option value="" @if ( !old('role') ) selected @endif>選択してください</option>
                @foreach($roles as $role)
                    <option value="{{ $role['key'] }}" @if ( old('role') == $role['key'] ) selected @endif >{{ $role['value'] }}</option>
                @endforeach
            </select>
            @error('role')
            <div class="invalid-feedback">
                <div class="text-danger">{{ $message }}</div>
            </div>
            @enderror
        </div>
        <div class="form-group">
            <label for="inputPassword1">パスワード <span class="badge badge-danger">必須</span></label>
            <input name="password" class="form-control @error('password') is-invalid @enderror" id="inputPassword1" type="password" aria-describedby="passwordHelp" value="" required>
            @error('password')
            <div class="invalid-feedback">
                <div class="text-danger">{{ $message }}</div>
            </div>
            @enderror
        </div>
        <div class="form-group clearfix">
            <div class="float-left">
                <button class="btn btn-primary" type="submit">保存する</button>
            </div>
        </div>
        {{ Form::close() }}
    </div>
@endsection
