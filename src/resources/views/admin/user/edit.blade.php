@extends('layouts.app')

@section('title'){{ config('titles.user.edit') }}@endsection

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
            <a href="{{ url('admin/user') }}" class="d-block"><i class="fas fa-chevron-circle-left"></i> 前のページへ戻る</a>
            <h1 class="d-inline-block mb-0 mr-2 align-middle">{{ config('titles.user.edit') }}</h1>
        </div>
        {{ Form::open(['url' => "admin/user/{$user->id}", 'method' => 'POST']) }}
            @include('admin.components.input_edit', [
                'labelName'     => 'ユーザー名',
                'name'          => 'name',
                'type'          => 'text',
                'id'            => 'inputName1',
                'placeholder'   => 'ユーザー名',
                'value'         => $user->name,
                'required'      => true,
            ])
            @include('admin.components.input_edit', [
                'labelName'     => 'メールアドレス',
                'name'          => 'email',
                'type'          => 'email',
                'id'            => 'inputEmail1',
                'placeholder'   => 'sample@example.com',
                'value'         => $user->email,
                'required'      => true,
            ])
            @include('admin.components.select_edit', [
                'labelName'     => 'ユーザー権限',
                'name'          => 'role_type',
                'id'            => 'inputRole1',
                'items'         => \UserRoleTypeViewHelper::getSelectAll(),
                'value'         => $user->role_type,
                'required'      => true
            ])
            @include('admin.components.input_edit', [
                'labelName'     => 'パスワード',
                'name'          => 'password',
                'type'          => 'password',
                'id'            => 'inputPassword1',
                'required'      => true,
            ])
            @include('admin.components.button_submit')
        {{ Form::close() }}
    </div>
@endsection
