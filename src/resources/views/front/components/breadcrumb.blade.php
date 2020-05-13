<nav class="blog-breadcrumb" aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('') }}"> <i class="fas fa-home"></i> Home</a></li>
        <li class="breadcrumb-item"><a href="{{ url('category/'.$post->categories->name) }}">{{ $post->categories->name }}</a></li>
        <li class="breadcrumb-item active">{{ $post->title }}</li>
    </ol>
</nav>
