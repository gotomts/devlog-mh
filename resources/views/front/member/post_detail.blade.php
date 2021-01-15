@extends('front.layouts.app')

@section('title'){{ $post->title }}@endsection

@section('header_js')
@endsection

@section('css')
@endsection

@section('footer_js')
<script src="https://cdn.jsdelivr.net/gh/google/code-prettify@master/loader/run_prettify.js?lang=css&skin=desert"></script>
@endsection

@section('content')
<h1 class="text-center h2">
    <a href="{{ url('member/post') }}">
        {{ config('titles.front.member.post') }}
    </a>
</h1>
<article class="blog-post">
    <header class="blog-post-header">
        <h1 class="blog-post-title">{{ $post->title }}</h1>
        <p class="blog-post-meta">
            @include('front.components.date_formated', ['date' => $post->created_at])
            <a href="{{ url('member/post/category/'.$post->categories->name) }}">{{ $post->categories->name }}</a>
        </p>
    </header>
    @if (isset($post->postImages))
    <a href="{{ url($post->url) }}">
        <figure class="text-center">
            <img class="img-fluid" src="{{ $post->postImages->url }}" title="{{ $post->postImages->title }}"
                alt="{{ $post->postImages->alt }}">
        </figure>
    </a>
    @endif
    {!! $post->html_content !!}

    @include('front.components.pagination', [
        'page' => 'member/post',
        'prevLink' => $prevLink,
        'nextLink' => $nextLink,
    ])
</article>

@endsection
