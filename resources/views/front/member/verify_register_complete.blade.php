@extends('front.layouts.app')

@section('title'){{ config('titles.front.member.verify_register_complete') }}@endsection

@section('header_js')
@endsection

@section('css')
@endsection

@section('footer_js')
<script src="https://cdn.jsdelivr.net/gh/google/code-prettify@master/loader/run_prettify.js?lang=css&skin=desert">
</script>
@endsection

@section('content')
<h1 class="text-center h2">{{ config('titles.front.member.verify_register_complete') }}</h1>
仮会員登録が完了しました。
@endsection
