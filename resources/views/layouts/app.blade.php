<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @yield('page_title')
    <!--<title>{{ config('app.name') }}</title>-->

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Viga&display=swap" rel="stylesheet">

    <link rel="icon" type="image/png" href="/storage/images/logo.png"/>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/rehome.css') }}" rel="stylesheet">

</head>
<body>
    <div id="app">
        {{--

        
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="logo navbar-brand" href="{{ url('/') }}">
                    <img src="{{ logoImage() }}" alt="{{ config('app.name') }}">
                    <span class="m-2">{{ config('app.name') }}</span>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        @auth
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('home') }}">{{ __('Home') }}</a>
                            </li>
                        @endauth
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('profile')}}">
                                      {{ __('Profile') }}
                                    </a>

                                    <a class="dropdown-item" href="{{ route('settings')}}">
                                      {{ __('Settings') }}
                                    </a>

                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="">
            @yield('content')
        </main>

        <div class="footer d-flex flex-column justify-content-center align-items-center">
            <div class="container d-flex justify-content-around align-items-center">
                <div class="item p-4">
                    <div class="logo">
                        <img src="{{ logoImage() }}" alt="{{ config('app.name') }}">
                        <p>rehome++</p>
                    </div>
                    <p>HAL名古屋　未来創造展2020<br></p>
                    <p>グループ番号: H424<br></p>
                    <p>リーダー　　: 船戸啓世</p>
                    <div>
                        <a target="_blank" href="set_your_social" rel="noopener" class="icon fa fa-twitter"></a>
                        <a target="_blank" href="set_your_social" rel="noopener" class="icon fa fa-facebook-f"></a>
                        <a target="_blank" href="set_your_social" rel="noopener" class="icon fa fa-instagram"></a>
                    </div>
                </div>
                <div class="item p-4">
                    <a href="set_your_link" rel="noopener" class="text">問い合わせ</a>
                    <a href="set_your_link" rel="noopener" class="text">ニュース<br></a>
                    <a href="set_your_link" rel="noopener" class="text">プライバシーポリシー<br></a>
                    <a href="set_your_link" rel="noopener" class="text">サイトマップ<br></a>
                    <a href="set_your_link" rel="noopener" class="text">FAQ</a>
                </div>
            </div>
            <div class="copyright text-center p-2">
                ©︎ 2020 rehome++, inc
            </div>
        </div>
    --}}
    </div>
</body>
</html>
