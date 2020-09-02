@extends('layouts.app')

@section('title'){{ config('titles.image.list') }}@endsection

@section('header_js')
@endsection

@section('css')
@endsection

@section('footer_js')
@endsection

@section('content')
    <div class="container mb-5">
        <div class="page-title">
            <a href="{{ url('admin') }}" class="d-block"><i class="fas fa-chevron-circle-left"></i> 前のページへ戻る</a>
            <h1 class="d-inline-block mb-0 mr-2 align-middle">{{ config('titles.image.list') }}</h1>
        </div>
        @include('flash::message')
        {{ Form::open(['url' => 'admin/image/upload', 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
            <div class="form-group">
              {{ Form::file('imagefile', ['class' => 'form-control-file']) }}
              @include('admin.components.upload_validate_message', ['property' => 'imagefile'])
            </div>
            <div class="form-group clearfix">
                <div class="float-left">
                    <button class="btn btn-primary" type="submit">画像をアップロードする</button>
                </div>
            </div>
        {{ Form::close() }}
         <div class="row">
            @foreach ($images as $image)
                <div class="col-2 mb-4">
                    <a href="image/edit/{{$image->id}}">
                        <img class="img-fluid" src="{{$image->url}}" alt="{{$image->alt}}" title="{{$image->title}}">
                    </a>
                </div>
            @endforeach
        </div>
        <div class="d-flex justify-content-center">
            {{ $images->links() }}
        </div>
    </div>
@endsection
