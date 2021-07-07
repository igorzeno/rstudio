<!doctype html>
<html lang="ru">
<head>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="/css/style.css?<?=mt_rand()?>" />
    <link rel="stylesheet" href="/css/account.css?<?=mt_rand()?>" />
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @yield('custom_js')
    @yield('custom_css')
</head>
<body>
<div class="container">

    <header>
        <div class="pc__menu">
            <div class="header__logo"><div class="header__img"><a href="/"><span class="site__f">Rekastudio-</span><span class="site__domen">test</span></a></div>
                <div class="header__line">
                    <ul class="header__menu">
                        <li><a class="" href="/">Главная</a></li>
                    </ul>
                </div>
                <div class="header__man">
                    @auth
                        <div class="site__login">{{ auth()->user()->name ? auth()->user()->name:"No name"}}&nbsp;&nbsp;</div>
                        <div class="site__login_vert">|</div>
                        <div class="site__login">
                            <form action="{{ route('logout') }}" method="post">
                                @csrf
                                <button type="submit">Выход</button>
                            </form>
                        </div>
                    @endauth

                    @guest
                        <div class="site__login"><a href="{{ route('register') }}">Регистрация</a></div>
                        <div class="site__login">|</div>
                        <div class="site__login"><a href="{{ route('login') }}">Войти</a></div>
                    @endguest
                </div>
            </div>
            <div class="header__nav">
                <div class="lupa"></div>
            </div>
        </div>

    </header>
    @yield('content')
</div>

</body>
</html>
