@extends('layouts.app')

@section('title'){{ config('titles.post.list') }}@endsection

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
            <h1 class="d-inline-block mb-0 mr-2 align-middle">{{ config('titles.post.list') }}</h1>
            <a class="btn btn-primary align-middle" href="{{ url('admin/post/create')  }}">新規作成</a>
        </div>
        <div class="table-responsive-xl">
            <table class="table table-striped table-hover table-bordered">
                <thead>
                    <tr>
                        <th class="text-center text-nowrap" scope="col"></th>
                        <th class="text-center text-nowrap" scope="col">編集</th>
                        <th class="text-center text-nowrap" scope="col">記事タイトル</th>
                        <th class="text-center text-nowrap" scope="col">カテゴリー</th>
                        <th class="text-center text-nowrap" scope="col">ステータス</th>
                        <th class="text-center text-nowrap" scope="col">投稿者</th>
                        <th class="text-center text-nowrap" scope="col">更新日時</th>
                      </tr>
                </thead>
                <tbody>
                @if (count($posts) === 0)
                    <tr>
                        <td class="text-center" colspan="4">データが存在しませんでした。記事を投稿してください。</td>
                    </tr>
                @endif
                @foreach($posts as $post)
                <tr>
                    <td class="text-center text-nowrap"></td>
                    <td class="text-center"><a class="btn btn-secondary btn-sm" href='{{ url("admin/post/edit/{$post->id}") }}'>編集</a></td>
                    <td class="text-center">{{ $post->title }}</td>
                    <td class="text-center">{{ $post->categories->name }}</td>
                    <td class="text-center">
                    @if ($post->statuses->name === "下書き")
                        <span class="badge badge-secondary">{{ $post->statuses->name }}</span>
                    @elseif ($post->statuses->name === "公開")
                        <span class="badge badge-success">{{ $post->statuses->name }}</span>
                    @endif
                    </td>
                    <td class="text-center text-nowrap">{{ $post->user->name }}</td>
                    <td class="text-center text-nowrap">{{ $post->updated_at->format('Y/m/d H:i:s') }}</td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        @include('admin.components.pagilinks', ['property' => $posts])
    </div>
@endsection
