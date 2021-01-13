@extends('front.layouts.app')

@section('title'){{ config('titles.front.member.top') }}@endsection

@section('header_js')
@endsection

@section('css')
@endsection

@section('footer_js')
<script src="https://cdn.jsdelivr.net/gh/google/code-prettify@master/loader/run_prettify.js?lang=css&skin=desert">
</script>
@endsection

@section('content')
<h1 class="text-center h2">{{ config('titles.front.member.top') }}</h1>
<p class="alert alert-success text-center">
    会員情報の編集が完了しました。
</p>
<div>
    <p>
        <a href="member-post.html" class="btn btn-lg btn-primary btn-block">会員限定ページ一覧</a>
    </p>
    <p>
        <a href="{{ url('member/edit') }}" class="btn btn-lg btn-primary btn-block">会員情報を編集</a>
    </p>
    <p class="text-center mt-3">
        <a href="#" class="logout-btn">ログアウト</a>
    </p>
</div>
@endsection
