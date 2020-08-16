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
            <a class="btn btn-secondary btn-lg btn-block" href="{{ url('admin/post') }}">{{ config('titles.post.list') }}  &raquo;</a>
            <a class="btn btn-secondary btn-lg btn-block" href="{{ url('admin/image') }}">{{ config('titles.image.list') }}  &raquo;</a>
            <a class="btn btn-secondary btn-lg btn-block" href="{{ url('admin/user') }}">{{ config('titles.user.list') }} &raquo;</a>
            <a class="btn btn-secondary btn-lg btn-block" href="{{ url('admin/category') }}">{{ config('titles.category.list') }} &raquo;</a>
        </div>
    </div>
@endsection
