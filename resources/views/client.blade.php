<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Интернет-магазин масштабных моделей">
    <meta name="keywords" content="Масштабные модели, интернет-магазин, доставка, авиация, бронетехника, краски">

    <title>{{ $title }}</title>

    <link href="/css/bootstrap.css" rel="stylesheet">
    <link href="/css/fonts.css" rel="stylesheet">
    <link href="/css/style.css" rel="stylesheet">
</head>
<body>

@if (session()->has('messageAuth'))
    <div class="alert alert-danger">
        {{ session()->get('messageAuth') }}
    </div>
@endif

{{--Шапка--}}
<header class="container-fluid">
    <div class="row padding-top"></div>
    <div class="row">
        <div class="col-lg-4 col-md-3 col-sm-2 hidden-xs text-left">
            {{--<img class="logo-image" src="/images/logo.jpg" />--}}
        </div>
        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 text-center">
            {{--Панель поиска--}}
            <div class="container-fluid">
                <div class="row">
                    <form name="search" method="post" action="{{ route('search') }}">
                        {{ csrf_field() }}
                        <div id="fieldSearch" class="input-group">
                            <div id="phraseList"></div>
                            <input id="searchPhrase" type="text" class="form-control" name="searchPhrase"
                                   value="{{ $searchPhrase ?? '' }}" placeholder="поиск" autocomplete="off">
                            <div class="input-group-btn">
                                <button type="submit" class="btn"><span class="glyphicon glyphicon-search"
                                                                        aria-hidden="true"></span></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-3 col-sm-2 col-xs-12 divCartButton">
            {{--Кнопка корзины--}}
            <a href="{{ route('cart') }}" class="btn cartButton">
                <span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span>
                <div id="fieldCartButton">
                    <div id="cartButtonTotalCost"></div>
                    <span class="glyphicon glyphicon-ruble" aria-hidden="true"></span>
                    <div id="cartButtonTotalQuantity"></div>
                </div>
                <span id="cartButtonName">Корзина</span>
            </a>
            @if (true == Auth::guest())
                <a href="{{ route('login') }}" class="btn ">Войти</a>
                <a href="{{ route('register') }}" class="btn">Регистрация</a>
            @else
                <a href="{{ route('logout') }}" class="btn cartButton" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                    {{ Auth::user()->name }} - Выход
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            @endif
        </div>
    </div>
    <div class="row padding-top"></div>
</header>

{{--Навигация--}}
<nav class="container-fluid">
    <div class="row">
        <div role="navigation" class="navbar navbar-inverse">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <div id="navbarCollapse" class="collapse navbar-collapse">
                    <ul class="nav nav-pills text-center">
                        <li><a href="/"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
                        @if(isset($categories) and 0 < count($categories))
                            @foreach($categories as $category)
                                <li role="presentation" class="dropdown">
                                    <a class="dropdown-toggle" data-toggle="dropdown" href="" role="button"
                                       aria-haspopup="true" aria-expanded="false">
                                        {{ $category->name }} <span class="caret"></span>
                                    </a>
                                    @if(0 < count($category->children))
                                        <ul class="dropdown-menu">
                                            @foreach($category->children as $child)
                                                <li><a href="/category/{{ $child->id }}">{{ $child->name }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </li>
                            @endforeach
                        @endif
                        @can('backup', new \Kopp\Product())
                            <li><a href="{{ route('admin') }}">Администрирование</a></li>
                        @endcan
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>

{{--Основной блок--}}
<div class="container-fluid content">
    <div class="row">
        <div class="left-side-bar col-lg-2 hidden-md hidden-sm hidden-xs">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Новинки</h3>
                </div>
                <div class="panel-body">
                    <h4>Аркадий Паровозов</h4>
                    <p>Непослушные Саша и Маша снова исследуют окружающий мир. А вы задумывались когда-нибудь, почему
                        Аркадий Паровозов всегда-всегда успевает спасти их? Предлагаем выступить в роли помощников и
                        диспетчеров легендарного героя – немного понаблюдать за Сашей, Машей и котом и помочь Аркадию
                        Паровозову появиться точно в срок!<br/>Поле из независимых модулей позволяет каждый раз
                        составить новую карту перемещений Саши и Маши, что даёт шанс игрокам каждый раз изобрести новую
                        стратегию победы.<br/>15 новых историй об Аркадии Паровозове научат, как действовать в
                        непредвиденных ситуациях и, несомненно, развлекут детей и взрослых.</p>
                    <h4>Бумажки</h4>
                    <p>Где-то в бумажной местности жили лось по имени Аристотель и дятел Тюк-Тюк, и очень их беспокоило,
                        кого и что они смогут встретить в самых удаленных уголках Бумажной страны.<br/>В данной игре вам
                        предстоит путешествовать по бумажной стране и собирать различные фигуры из бумаги. Собирайте и
                        складывайте оригами вместе с героями мультфилма "Бумажки", а самый проворный и умелый
                        исследователь Бумажной страны станет победителем.</p>
                </div>
            </div>
        </div>
        <div class="col-lg-8 col-md-9 col-sm-9 col-xs-12">
            <div class="row">
                {{--Содержимое--}}
                @yield('content')
            </div>
        </div>
        <div class="right-side-bar col-lg-2 col-md-3 col-sm-3 hidden-xs">
            {{--Панель входа--}}
            {{--<div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Вход</h3>
                </div>
                <div class="panel-body">
                    <form --}}{{--method="post" action="{{ route('login') }}"--}}{{-->
                        {{ csrf_field() }}
                        <div class="form-group">
                            <input type="email" class="form-control" name="email" placeholder="e-mail"/>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" name="password" placeholder="пароль"/>
                            <a href="#--}}{{--{{ route('reset') }}--}}{{--" class="pull-right">Забыли пароль?</a>
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox"/> Запомнить меня
                            </label>
                        </div>
                        <button type="submit" class="btn pull-right">Войти</button>
                    </form>
                </div>
                <div class="panel-footer text-center">
                    <h3 class="panel-title">
                        <a href="#--}}{{--{{ route('register') }}--}}{{--">Регистрация</a>
                    </h3>
                </div>
            </div>--}}

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Новости</h3>
                </div>
                <div class="panel-body">
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci blanditiis cum error iste
                        laboriosam minus modi, odit quaerat ratione voluptas. Aspernatur consectetur delectus eius eum
                        reiciendis reprehenderit sunt voluptas voluptates!</p>
                </div>
            </div>
        </div>
    </div>
</div>

{{--Подвал--}}
<footer class="container-fluid">
    <div class="row padding-top">
        <div class="col-lg-2 col-md-6 col-sm-6 col-xs-6 text-right">
            <p>г. Новосибирск, 2017</p>
        </div>
        <div class="col-lg-8 hidden-md hidden-sm hidden-xs text-center">
            <p>{{ config('app.name') }}</p>
        </div>
        <div class="col-lg-2 col-md-6 col-sm-6 col-xs-6 text-left">
            <p>+7 (913) 796-96-36</p>
        </div>
    </div>
</footer>

{{--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>--}}
<script src="/js/jquery-3.2.0.min.js"></script>
<script src="/js/bootstrap.js"></script>
<script src="/js/xmlHttpRequest.js"></script>
<script src="/js/init.js"></script>
<script src="/js/searchPhrase.js"></script>
<script src="/js/cart.js"></script>
</body>
</html>