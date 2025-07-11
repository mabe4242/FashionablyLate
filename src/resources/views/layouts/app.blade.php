<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Contact Form</title>
    <link rel="stylesheet" href="{{ asset('css/layouts/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/layouts/common.css') }}" />
    @yield('css')
</head>
<body>
    <header class="header">
        <div class="header__inner">
            <div class="header-flex">
                <div class="header-center">
                    <a class="header__logo" href="/">
                        FashionablyLate
                    </a>
                </div>
                <div class="header-right">
                    @if (Auth::check())
                        <form class="form" action="/logout" method="POST">
                            @csrf
                            <button class="header-nav__button">ログアウト</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </header>
    <main>
        @yield('content')
    </main>
</body>
</html>
