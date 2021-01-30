@extends('front.layouts.app')

@section('header_js')
@endsection

@section('css')
@endsection

@section('footer_js')
<script src="https://cdn.jsdelivr.net/gh/google/code-prettify@master/loader/run_prettify.js?lang=css&skin=desert">
</script>
@endsection

@section('content')
@foreach ($posts as $post)
<article class="blog-post">
    <header class="blog-post-header">
        <h1 class="blog-post-title"><a class="text-dark" href="{{ url('blog/'.$post->url) }}">{{ $post->title }}</a></h1>
        <p class="blog-post-meta">
            @include('front.components.date_formated', ['date' => $post->created_at])
            <a href="{{ url('category/'.$post->categories_name) }}">{{ $post->categories_name }}</a>
        </p>
    </header>
    @if (isset($post->postImages))
    <a href="{{ url('blog/'.$post->url) }}">
        <figure class="text-center">
            <img class="img-fluid" src="{{ $post->post_images_url }}" title="{{ $post->post_images_title }}" alt="{{ $post->post_images_alt }}">
        </figure>
    </a>
    @endif
    <div>
        {!! \ContentViewHelper::getExistsMoreContent($post->html_content) !!}
        <p><a class="btn btn-primary" href="{{ url('blog/'.$post->url) }}">続きを読む</a></p>
    </div>
</article>
@endforeach
@include('front.components.pagilinks', ['property' => $posts])
@endsection
