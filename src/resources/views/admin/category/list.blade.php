@extends('layouts.app')

@section('title'){{ config('titles.category.list') }}@endsection

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
            <a href="{{ url('admin') }}" class="d-block"><i class="fas fa-chevron-circle-left"></i> 前のページへ戻る</a>
            <h1 class="d-inline-block mb-0 mr-2 align-middle">{{ config('titles.category.list') }}</h1>
            <a class="btn btn-primary align-middle" href="{{ url('admin/category/create')  }}">新規作成</a>
        </div>
        <div class="table-responsive-xl">
            <table class="table table-striped table-hover table-bordered">
                <thead>
                <tr>
                    <th class="text-center text-nowrap" scope="col">編集</th>
                    <th class="text-center text-nowrap" scope="col">カテゴリー名</th>
                    <th class="text-center text-nowrap" scope="col">更新者</th>
                    <th class="text-center text-nowrap" scope="col">更新日時</th>
                </tr>
                </thead>
                <tbody>
                @if (count($categories) === 0)
                    <tr>
                        <td class="text-center" colspan="4">データが存在しませんでした。カテゴリを登録してください。</td>
                    </tr>
                @endif
                @foreach($categories as $category)
                <tr>
                    <td class="text-center"><a class="btn btn-secondary btn-sm" href='{{ url("admin/category/{$category->id}") }}'>編集</a></td>
                    <td class="text-nowrap">{{ $category->name }}</td>
                    <td class="text-center text-nowrap">{{ $category->updated_name }}</td>
                    <td class="text-center text-nowrap">{{ $category->updated_at }}</td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        @include('admin.components.pagilinks', ['property' => $categories])
    </div>
@endsection
