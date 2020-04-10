@extends('layouts.app')

@section('title'){{ config('titles.home.top') }}@endsection

@section('header_js')
@endsection

@section('css')
@endsection

@section('footer_js')
@endsection

@section('content')
    <div class="flex-body">
        <div class="form-signin">
            <h1 class="text-center">管理画面</h1>
            <a class="btn btn-secondary btn-lg btn-block" href="{{ url('mh-login/post') }}">投稿記事管理  &raquo;</a>
            <a class="btn btn-secondary btn-lg btn-block" href="{{ url('mh-login/upload') }}">画像管理  &raquo;</a>
            <a class="btn btn-secondary btn-lg btn-block" href="{{ url('mh-login/user') }}">ユーザー管理 &raquo;</a>
            <a class="btn btn-secondary btn-lg btn-block" href="{{ url('mh-login/category') }}">{{ config('titles.category.list') }} &raquo;</a>
        </div>
    </div>
@endsection
