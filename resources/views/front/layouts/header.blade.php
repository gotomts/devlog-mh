<header>
    <h1 class="logo text-center"><a href="/">{{ config('app.name') }}</a></h1>
    <p class="text-center">Webデザイナーから転職してWeb系エンジニアとして働いています。日々の技術ログとして使いたい。</p>
    <nav class="navbar navbar-expand-lg border-top border-bottom navbar-light nav-text-black mb-5">
        <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse justify-content-md-center" id="navbar">
            <ul class="navbar-nav">
                @foreach ($navItems as $navItem)
                    <li class="nav-item"><a class="nav-link" href="{{ url('category/'.$navItem->name) }}">{{ $navItem->name }}</a></li>
                @endforeach
            </ul>
        </div>
    </nav>
</header>
