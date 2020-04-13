@extends('layouts.app')

@section('title'){{ config('titles.category.create') }}@endsection

@section('header_js')
@endsection

@section('css')
@endsection

@section('footer_js')
@endsection

@section('content')
    <div class="container mb-5">
        <div class="page-title">
            <a href="{{ url('admin/category') }}" class="d-block"><i class="fas fa-chevron-circle-left"></i> 前のページへ戻る</a>
            <h1 class="d-inline-block mb-0 mr-2 align-middle">{{ config('titles.category.create') }}</h1>
        </div>
        {{ Form::open(['url' => 'admin/category/create', 'method' => 'POST']) }}
        <div class="form-group">
            <label for="inputCategory1">カテゴリー名</label>
            <input name="name" class="form-control @error('name') is-invalid @enderror" id="inputCategory1" type="text" aria-describedby="categoryHelp" placeholder="カテゴリー名" value="{{ old('name') }}" required>
            @error('name')
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
