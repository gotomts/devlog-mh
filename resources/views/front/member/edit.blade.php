@extends('front.layouts.app')

@section('title'){{ config('titles.front.member.edit') }}@endsection

@section('header_js')
@endsection

@section('css')
@endsection

@section('footer_js')
<script src="https://cdn.jsdelivr.net/gh/google/code-prettify@master/loader/run_prettify.js?lang=css&skin=desert">
</script>
@endsection

@section('content')
<h1 class="text-center h2">{{ config('titles.front.member.edit') }}</h1>
@include('front.components.flash_message')
{{ Form::open(['url' => url("member/edit/{$member->id}"), 'method' => 'POST']) }}
@include('front.components.input_edit', [
'labelName' => 'ニックネーム',
'name' => 'name',
'type' => 'text',
'id' => 'inputName',
'placeholder' => 'ニックネーム',
'required' => true,
'autofocus' => true,
'value' => $member->name
])
@include('front.components.input_edit', [
'labelName' => 'メールアドレス',
'name' => 'email',
'type' => 'email',
'id' => 'inputEmail',
'placeholder' => 'メールアドレス',
'required' => true,
'value' => $member->email
])
<p>パスワードを変更する場合のみ下記を入力してください。</p>
@include('front.components.input_edit', [
'labelName' => '古いパスワードを入力',
'name' => 'old_password',
'type' => 'password',
'id' => 'inputOldPassword',
'placeholder' => '古いパスワードを入力'
])
@include('front.components.input_edit', [
'labelName' => '新しいパスワードを入力',
'name' => 'new_password',
'type' => 'password',
'id' => 'inputNewPassword',
'placeholder' => '新しいパスワードを入力'
])
@include('front.components.input_edit', [
'labelName' => '新しいパスワードを再度入力',
'name' => 'new_password_confirmation',
'type' => 'password',
'id' => 'inputNewPasswordConfirm',
'placeholder' => '新しいパスワードを再度入力'
])
@include('front.components.button_submit', [
'btnLabel' => '更新する'
])
{{ Form::close() }}

@endsection