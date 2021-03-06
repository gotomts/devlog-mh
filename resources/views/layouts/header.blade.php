<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="{{ url('admin') }}">{{ config('app.name') }}</a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto"></ul>
            @auth('admin')
                {{ Form::open(['url' => 'admin/logout', 'method' => 'POST', 'id' => 'logout-form', 'class' => 'hidden']) }}
                {{ Form::close() }}
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="{{ url('admin/profile/edit') }}">{{ config('titles.profile.edit') }}</a></li>
                    <li class="nav-item"><a class="nav-link logout-btn" href="#">ログアウト</a></li>
                </ul>
            @endauth
        </div>
    </nav>
</header>

