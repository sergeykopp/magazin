@extends('client')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">{{ $title }}</h3>
        </div>
        <div class="panel-body">
            <div class="container-fluid text-center">
                <div class="row">
                    @if (0 < count($products))
                        @foreach($products as $product)
                            <div class="product-block text-left col-lg-2 col-md-3 col-sm-5 col-xs-5">
                                <a href="{{ route('product') }}/{{ $product->id }}">
                                    @if(0 < $product->discount)
                                        <img class="sale" src="/images/statuses/red.png" />
                                        <div class="saleValue">Скидка<br />{{ $product->discount }}%</div>
                                    @endif
                                    <div class="product-image-block text-center">
                                        <img src="/images/products/small/{{ $product->brand->name }}/{{ $product->artikul }}.gif" />
                                    </div>
                                        <h4 class="product-info">{{ $product->brand->name }}, {{ $product->name }}</h4>
                                </a>
                                <p>Артикул: {{ $product->artikul }}</p>
                                @if(0 < $product->discount)
                                    <p>Цена: <span class="old-price">{{ $product->price }}</span> <span class="price">{{ floor(($product->price*(0.1-$product->discount/1000)))*10 }}</span> <span class="glyphicon glyphicon-ruble" aria-hidden="true"></span></p>
                                @else
                                    <p>Цена: <span class="price">{{ $product->price }}</span> <span class="glyphicon glyphicon-ruble" aria-hidden="true"></span></p>
                                @endif
                                <span class="buy btn" productId="{{ $product->id }}"><span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span> Купить</span>
                            </div>
                        @endforeach
                    @else
                        <p>По вашему запросу ничего не найдено</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection