@extends('layouts.app')

@section('title'){{ config('titles.post.edit') }}@endsection

@section('header_js')
@endsection

@section('css')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote.min.css" rel="stylesheet">
@endsection

@section('footer_js')
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
    <script src="{{ asset('js/admin/post.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/gh/google/code-prettify@master/loader/run_prettify.js?lang=css&skin=desert"></script>
@endsection

@section('content')
    <div class="container mb-5">
        @include('admin.components.flash_message')
        <div class="page-title">
            <a href="{{ url('admin/post') }}" class="d-block"><i class="fas fa-chevron-circle-left"></i> 前のページへ戻る</a>
            <h1 class="d-inline-block mb-0 mr-2 align-middle">{{ config('titles.post.create') }}</h1>
        </div>
        {{ Form::open(['url' => "admin/post/edit/$post->id", 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
            @include('admin.components.input_edit', [
                'labelName'     => 'タイトル',
                'name'          => 'title',
                'type'          => 'text',
                'id'            => 'inputTitle',
                'placeholder'   => 'タイトル',
                'value'         => $post->title,
                'required'      => true,
            ])
            @include('admin.components.input_prepend_edit', [
                'labelName'     => 'URL',
                'name'          => 'url',
                'type'          => 'text',
                'id'            => 'inputUrl',
                'value'         => $post->url,
                'required'      => true,
            ])
            @include('admin.components.input_edit', [
                'labelName'     => 'キーワード',
                'name'          => 'keyword',
                'type'          => 'text',
                'id'            => 'inputKeyword',
                'placeholder'   => 'keyword1, keyword2',
                'value'         => $post->keyword,
            ])
            @include('admin.components.textarea_edit', [
                'labelName'     => 'ディスクリプション',
                'id'            => 'textareaDescription',
                'name'          => 'description',
                'rows'          => '3',
                'placeholder'   => 'ディスクリプション',
                'value'         => $post->description,
            ])
            @include('admin.components.select_edit', [
                'labelName'     => 'カテゴリーを選択',
                'name'          => 'category_id',
                'id'            => 'inputCategory1',
                'items'         => \CategoryTypeViewHelper::getSelectAll(),
                'value'         => $post->category_id,
                'required'      => true,
            ])
            @include('admin.components.select_edit', [
                'labelName'     => 'ステータスを選択',
                'name'          => 'status_id',
                'id'            => 'inputStatus1',
                'items'         => \StatusTypeViewHelper::getSelectAll(),
                'value'         => $post->status_id,
                'required'      => true,
            ])
            @if (isset($post->postImages))
                @include('admin.components.file_upload', [
                    'labelName'     => 'アイキャッチ画像',
                    'name'          => 'imagefile',
                    'url'           => $post->postImages->url,
                    'alt'           => $post->postImages->alt,
                    'title'         => $post->postImages->title,
                    'id'            => 'inputFile1',
                    'class'         => 'form-control-file',
                ])
            @else
                @include('admin.components.file_upload', [
                    'labelName'     => 'アイキャッチ画像',
                    'name'          => 'imagefile',
                    'id'            => 'inputFile1',
                    'class'         => 'form-control-file',
                ])
            @endif
            <div class="form-group">
                <div class="tabs">
                    <input id="markdown" type="radio" name="tab-item" checked>
                    <label for="markdown" class="tab-item">Markdown</label>
                    <input id="html" type="radio" name="tab-item" />
                    <label for="html" class="tab-item">HTML</label>
                    <div class="tab-content" id="markdown-content">
                        <textarea name="markdown_content" class="markdown-area" id="content" placeholder="ここから記事を書き始めてください...">{{ $post->markdown_content }}</textarea>
                    </div>
                    <div class="tab-content" id="html-content">
                        <div id="html-preview"></div>
                        <input type="hidden" name="html_content" id="hidden-content">
                    </div>
                </div>
            </div>
            @include('admin.components.button_submit', ['class' => 'save'])
        {{ Form::close() }}
    </div>
@endsection
