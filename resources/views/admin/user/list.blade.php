@extends('layouts.app')

@section('title'){{ config('titles.user.list') }}@endsection

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
            <a href="{{ url('admin')  }}" class="d-block"><i class="fas fa-chevron-circle-left"></i> 前のページへ戻る</a>
            <h1 class="d-inline-block mb-0 mr-2 align-middle">{{ config('titles.user.list') }}</h1>
            <a class="btn btn-primary align-middle" href="{{ url('admin/user/create')  }}">新規作成</a>
        </div>
        <div class="table-responsive-xl">
            <table class="table table-striped table-hover table-bordered">
                <thead>
                <tr>
                    <th class="text-center text-nowrap" scope="col">編集</th>
                    <th class="text-center text-nowrap" scope="col">ユーザー名</th>
                    <th class="text-center text-nowrap" scope="col">更新者</th>
                    <th class="text-center text-nowrap" scope="col">更新日時</th>
                </tr>
                </thead>
                <tbody>
                @if (count($users) === 0)
                    <tr>
                        <td class="text-center" colspan="4">データが存在しませんでした。ユーザーを登録してください。</td>
                    </tr>
                @endif
                @foreach($users as $user)
                <tr>
                    <td class="text-center"><a class="btn btn-secondary btn-sm" href='{{ url("admin/user/edit/{$user->id}") }}'>編集</a></td>
                    <td class="text-nowrap">{{ $user->name }}</td>
                    <td class="text-center text-nowrap">{{ $user->updated_name }}</td>
                    <td class="text-center text-nowrap">{{ $user->updated_at->format('Y/m/d H:i:s') }}</td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        @include('admin.components.pagilinks', ['property' => $users])
    </div>
@endsection
