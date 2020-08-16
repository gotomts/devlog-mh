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
        @include('admin.components.flash_message')
        <div class="page-title">
            <a href="{{ url('admin/image') }}" class="d-block"><i class="fas fa-chevron-circle-left"></i> 前のページへ戻る</a>
            <h1 class="d-inline-block mb-0 mr-2 align-middle">{{ config('titles.image.create') }}</h1>
        </div>
        {{ Form::open(['url' => "admin/image/edit/{$id}", 'method' => 'POST']) }}
            <figure class="text-center">
                <img class="img-fluid" src="{{ $images->url }}" alt="{{ $images->alt }}" title="{{ $images->title }}">
            </figure>
            @include('admin.components.input_edit', [
                'labelName'  => 'title属性',
                'name' => 'title',
                'type' => 'text',
                'id' => 'inputTitle',
                'placeholder' => 'タイトル',
                'value' => $images->title,
            ])
            @include('admin.components.input_edit', [
                'labelName'  => 'alt属性',
                'name' => 'alt',
                'type' => 'text',
                'id' => 'inputAlt',
                'placeholder' => 'alt',
                'value' => $images->alt,
            ])
            @include('admin.components.button_submit')
        {{ Form::close() }}
    </div>
@endsection
