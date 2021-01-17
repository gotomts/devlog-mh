@extends('layouts.app')

@section('title'){{ config('titles.member.list') }}@endsection

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
            <h1 class="d-inline-block mb-0 mr-2 align-middle">{{ config('titles.member.list') }}</h1>
            <a class="btn btn-primary align-middle" href="{{ url('admin/member/create')  }}">新規作成</a>
        </div>
        <div class="table-responsive-xl">
            <table class="table table-striped table-hover table-bordered">
                <thead>
                <tr>
                    <th class="text-center text-nowrap" scope="col">編集</th>
                    <th class="text-center text-nowrap" scope="col">会員名</th>
                    <th class="text-center text-nowrap" scope="col">更新者</th>
                    <th class="text-center text-nowrap" scope="col">更新日時</th>
                </tr>
                </thead>
                <tbody>
                @if (count($members) === 0)
                    <tr>
                        <td class="text-center" colspan="4">データが存在しませんでした。会員を登録してください。</td>
                    </tr>
                @endif
                @foreach($members as $member)
                <tr>
                    <td class="text-center"><a class="btn btn-secondary btn-sm" href='{{ url("admin/member/edit/{$member->id}") }}'>編集</a></td>
                    <td class="text-nowrap">{{ $member->name }}</td>
                    <td class="text-center text-nowrap">{{ $member->updated_name }}</td>
                    <td class="text-center text-nowrap">{{ $member->updated_at->format('Y/m/d H:i:s') }}</td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        @include('admin.components.pagilinks', ['property' => $members])
    </div>
@endsection
