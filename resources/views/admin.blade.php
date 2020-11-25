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
                        {{--@if(isset($categories) and 0 < count($categories))
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
                        @endif--}}
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
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Новости</h3>
                </div>
                <div class="panel-body">

                </div>
            </div>
        </div>
    </div>
</div>

{{--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>--}}
<script src="/js/jquery-3.2.0.min.js"></script>
<script src="/js/bootstrap.js"></script>
</body>
</html>