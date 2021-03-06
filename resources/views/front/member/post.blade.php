@extends('front.layouts.app')

@section('title'){{ config('titles.front.member.post') }}@endsection

@section('header_js')
@endsection

@section('css')
@endsection

@section('footer_js')
<script src="https://cdn.jsdelivr.net/gh/google/code-prettify@master/loader/run_prettify.js?lang=css&skin=desert">
</script>
@endsection

@section('content')
<h1 class="text-center h2">
    <a href="{{ url('member/post') }}">
        {{ config('titles.front.member.post') }}
    </a>
</h1>
@foreach ($posts as $post)
<article class="blog-post">
    <header class="blog-post-header">
        <h1 class="blog-post-title"><a class="text-dark" href="{{ url('member/post/'.$post->url) }}">{{ $post->title }}</a>
        </h1>
        <p class="blog-post-meta">
            @include('front.components.date_formated', ['date' => $post->created_at])
            <a href="{{ url('member/category/'. $post->categories_name ) }}">{{ $post->categories_name }}</a>
        </p>
    </header>
    @if (isset($post->postImages))
    <a href="{{ url('member/post/'.$post->url) }}">
        <figure class="text-center">
            <img class="img-fluid" src="{{ $post->posts_images_url }}" title="{{ $post->posts_images_title }}"
                alt="{{ $post->posts_images_alt }}">
        </figure>
    </a>
    @endif
    <div>
        {!! \ContentViewHelper::getExistsMoreContent($post->html_content) !!}
        <p><a class="btn btn-primary" href="{{ url('member/post/'.$post->url) }}">続きを読む</a></p>
    </div>
</article>
@endforeach
@include('front.components.pagilinks', ['property' => $posts])
@endsection
