<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="{{ url('admin') }}">Mocha</a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto"></ul>
            @auth
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="{{ url('admin/profile') }}">プロフィール編集</a></li>
                    <li class="nav-item"><a id="logout-btn" class="nav-link" href="#">ログアウト</a></li>
                </ul>
            @endauth
        </div>
    </nav>
</header>

{{ Form::open(['url' => 'admin/logout', 'method' => 'POST', 'id' => 'logout-form', 'class' => 'hidden']) }}
{{ Form::close() }}
