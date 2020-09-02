@extends('layouts.app')

@section('title'){{ config('titles.category.edit') }}@endsection

@section('header_js')
@endsection

@section('css')
@endsection

@section('footer_js')
@endsection

@section('content')
    <div class="container mb-5">
        @include('admin.components.flash_message')
        <div class="page-title">
            <a href="{{ url('admin/category')  }}" class="d-block"><i class="fas fa-chevron-circle-left"></i> 前のページへ戻る</a>
            <h1 class="d-inline-block mb-0 mr-2 align-middle">{{ config('titles.category.edit') }}</h1>
        </div>
        {{ Form::open(['url' => url("admin/category/edit/{$category->id}"), 'method' => 'POST']) }}
            @include('admin.components.input_edit', [
                'labelName'     => 'カテゴリー名',
                'name'          => 'name',
                'type'          => 'text',
                'id'            => 'inputCategory1',
                'placeholder'   => 'カテゴリー名',
                'required'      => true,
                'value'         => $category->name
            ])
            @include('admin.components.button_submit')
        {{ Form::close() }}
    </div>
@endsection
