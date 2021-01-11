@extends('front.layouts.app')

@section('title'){{ config('titles.front.member.register_complete') }}@endsection

@section('header_js')
@endsection

@section('css')
@endsection

@section('footer_js')
<script src="https://cdn.jsdelivr.net/gh/google/code-prettify@master/loader/run_prettify.js?lang=css&skin=desert">
</script>
@endsection

@section('content')
<h1 class="text-center h2">{{ config('titles.front.member.register_complete') }}</h1>
@isset($message)
<p>
    {{$message}}
</p>
@endisset
@auth
<p>
    {{$name}}さん
</p>
<p>
    会員登録が完了しました。
    引き続き、Devlogをご利用ください。
</p>
<p class="text-center">
    <a href="member-top.html" class="btn btn-primary">
        続ける
    </a>
</p>
@endauth
@endsection
