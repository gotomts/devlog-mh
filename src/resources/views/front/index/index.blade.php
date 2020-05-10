@extends('front.layouts.app')

@section('header_js')
@endsection

@section('css')
@endsection

@section('footer_js')
@endsection

@section('content')
@foreach ($posts as $post)
<article class="blog-post">
    <header class="blog-post-header">
        <h1 class="blog-post-title"><a class="text-dark" href="{{ url($post->url) }}">{{ $post->title }}</a></h1>
        <p class="blog-post-meta">
            <time>2020/20/20</time>
            <a href="">{{ $post->categories->name }}</a>
        </p>
    </header>
    @if (isset($post->postImages))
    <a href="{{ url($post->url) }}">
        <figure class="text-center">
            <img class="img-fluid" src="{{ $post->postImages->url }}" title="{{ $post->postImages->title }}" alt="{{ $post->postImages->alt }}">
        </figure>
    </a>
    @endif
    <p>
        {{ $post->content }}
    </p>
    <p><a class="btn btn-primary" href="{{ url($post->url) }}">続きを読む</a></p>
</article>
@endforeach
@include('admin.components.pagilinks', ['property' => $posts])
@endsection
