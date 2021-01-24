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
@if (isset($member))
<p>{{$member['name']}}さん</p>
<p>
    {{$member['email']}}にメールを送信しました。<br>
    メールに記載のURLをクリックし、登録を完了してください。
</p>
<p class="text-center">
    <a href="{{ url('member/index') }}" class="btn btn-primary">
        続ける
    </a>
</p>
@else
<p>無効なURLです。</p>
@endif
@endsection
