@extends('layouts.app')

@section('title'){{ config('titles.image.create') }}@endsection

@section('header_js')
@endsection

@section('css')
@endsection

@section('footer_js')
@endsection

@section('content')
    <div class="container mb-5">
        <div class="page-title">
            <a href="{{ url('admin/image') }}" class="d-block"><i class="fas fa-chevron-circle-left"></i> 前のページへ戻る</a>
            <h1 class="d-inline-block mb-0 mr-2 align-middle">{{ config('titles.image.create') }}</h1>
        </div>
        {{ Form::open(['url' => 'admin/image/create', 'method' => 'POST']) }}
        <figure class="text-center">
            <img class="img-fluid" src="{{ $images['tmpPath'] }}" alt="登録前一時画像ファイル" title="登録前一時画像ファイル">
        </figure>
        <div class="form-group">
            <label for="inputTitle">title属性</label>
            <input class="form-control" id="inputTitle" type="text" placeholder="タイトル" name="title">
        </div>
        <div class="form-group">
            <label for="inputAlt">alt属性</label>
            <input class="form-control" id="inputAlt" type="text" placeholder="alt" name="alt">
        </div>
        <div class="form-group">
            <label for="inputUrl">URL</label>
            <input class="form-control" id="inputUrl" type="text" placeholder="URL" name="URL">
        </div>
        <div class="form-group">
            <button class="btn btn-primary" type="submit">保存する</button>
        </div>
        {{ Form::close() }}
    </div>
@endsection
