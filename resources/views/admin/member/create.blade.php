@extends('layouts.app')

@section('title'){{ config('titles.member.create') }}@endsection

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
        <a href="{{ url('admin/member') }}" class="d-block"><i class="fas fa-chevron-circle-left"></i> 前のページへ戻る</a>
        <h1 class="d-inline-block mb-0 mr-2 align-middle">{{ config('titles.member.create') }}</h1>
    </div>
    {{ Form::open(['url' => 'admin/member/create', 'method' => 'POST', 'novalidate']) }}
    @include('admin.components.input_new', [
    'labelName' => '会員名',
    'name' => 'name',
    'type' => 'text',
    'id' => 'inputName1',
    'placeholder' => '会員名',
    'required' => true
    ])
    @include('admin.components.input_new', [
    'labelName' => 'メールアドレス',
    'name' => 'email',
    'type' => 'email',
    'id' => 'inputEmail1',
    'placeholder' => 'メールアドレス',
    'required' => true
    ])
    @include('admin.components.checkbox_new', [
        'labelName' => '閲覧可能な会員種別を選択',
        'name' => 'member_types[]',
        'items' => $memberTypes,
        'types' => config('const.member_types.general'),
        'id' => 'inlineCheckbox',
        'messageProperty' => 'member_types',
        'required' => true
        ])
    @include('admin.components.input_new', [
    'labelName' => 'パスワード',
    'name' => 'password',
    'type' => 'password',
    'id' => 'inputPassword1',
    'required' => true
    ])
    @include('admin.components.button_submit')
    {{ Form::close() }}
</div>
@endsection
