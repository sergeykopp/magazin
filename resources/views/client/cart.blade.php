@extends('client')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">{{ $title }} [<span id="panelTotalQuantity">{{ $totalQuantity }}</span>]</h3>
        </div>
        @if(0 < count($products))
            <div class="panel-body cartPanelBody">
                @include('client.delivery')
                <div class="container-fluid">
                    @foreach($products as $product)
                        <div class="row cartRow">
                            <div class="col-lg-2 col-md-2 col-sm-3 col-xs-3">
                                <a href="{{ route('product') }}/{{ $product->id }}">
                                    <img src="/images/products/small/{{ $product->brand->name }}/{{ $product->artikul }}.gif" />
                                </a>
                            </div>
                            <div class="col-lg-7 col-md-7 col-sm-6 col-xs-6">
                                <a href="{{ route('product') }}/{{ $product->id }}">
                                    <p>{{ $product->brand->name }}, {{ $product->name }}</p>
                                </a>
                                <p>Артикул: {{ $product->artikul }}</p>
                            </div>
                            <div class="text-center col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                <p productId="{{ $product->id }}">
                                    <span class="price">{{ $product->price*$product->quantity }}</span><span class="glyphicon glyphicon-ruble" aria-hidden="true"></span><br />
                                    <span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
                                    <input type="text" class="cartProductQuantity text-center" value="{{ $product->quantity }}" />
                                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span><br />
                                    <span class="cartProductDelete">Удалить</span>
                                </p>
                            </div>
                        </div>
                    @endforeach
                    <div class="row cartRow">
                        <div class="text-right col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            Общая стоимость: <span id="panelTotalCost" class="price">{{ $totalCost }}</span><span class="glyphicon glyphicon-ruble" aria-hidden="true"></span>
                        </div>
                        <div class="text-left col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <a href="{{ route('viewOrder') }}">
                                <button class="btn">Оформить заказ</button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="panel-body">
                <h3 class="panel-title text-center">Корзина пуста</h3>
            </div>
        @endif
    </div>
@endsection