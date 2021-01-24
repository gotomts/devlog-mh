<header class="blog-header py-3">
    <div class="row flex-nowrap justify-content-between align-items-center">
        <div class="col-7">
            <a class="blog-header-logo text-dark" href="/">Devlog</a>
        </div>
        <div class="col-5 d-flex justify-content-end align-items-center">
            @guest('member')
            <a class="text-muted mr-3" href="{{ url('member/verify') }}">登録</a>
            <a class="btn btn-sm btn-outline-secondary" href="{{ url('member') }}">ログイン</a>
            @endguest
            @auth('member')
            {{ Form::open(['url' => 'member/logout', 'method' => 'POST', 'id' => 'logout-form', 'class' => 'hidden']) }}
            {{ Form::close() }}
            <a class="text-muted mr-3" href="{{ url('member/index') }}">会員情報</a>
            <a class="btn btn-sm btn-outline-secondary logout-btn" href="#">ログアウト</a>
            @endauth
        </div>
    </div>
</header>
<div class="nav-scroller py-1 mb-5">
    <nav class="nav d-flex justify-content-between">
        @foreach ($navItems as $navItem)
        <a class="p-2 text-muted" href="{{ url('category/'.$navItem->name) }}">{{ $navItem->name }}</a>
        @endforeach
    </nav>
</div>