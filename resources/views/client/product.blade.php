@extends('client')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">{{ $product->brand->name }}, {{ $product->name }}</h3>
        </div>
        <div class="panel-body">
            <div class="container-fluid">
                <div class="row">
                    <div class="text-center col-lg-6">
                        @if(0 < $product->discount)
                            <img class="sale" src="/images/statuses/red.png" />
                            <div class="saleValue">Скидка<br />{{ $product->discount }}%</div>
                        @endif
                        <img class="product-bigImage" src="/images/products/original/{{ $product->brand->name }}/{{ $product->artikul }}.gif"></img><br /><br />
                    </div>
                    <div class="col-lg-6">
                        <p><strong>Категория:</strong> <a href="{{ route('category') . '/' . $product->category->id }}">{{ $product->category->name }}</a></p>
                        <p class="text-justify"><strong>Описание:</strong> {!! $product->description !!}</p>
                        @if(0 < count($product->instructions))
                            @if(1 == count($product->instructions))
                                <p><strong>Инструкция:</strong> <a href="{{ asset('instructions/' . $product->brand->name . '/' . $product->instructions[0]) }}" target="_blank">скачать</a></p>
                            @else
                                @foreach($product->instructions as $key => $instruction)
                                    <p><strong>Инструкция {{ $key + 1 }}:</strong> <a href="{{ asset('instructions/' . $product->brand->name . '/' . $instruction) }}" target="_blank">скачать</a></p>
                                @endforeach
                            @endif
                        @endif
                        <p><strong>Производитель:</strong> {{ $product->brand->name }}</p>
                        <p><strong>Артикул:</strong> {{ $product->artikul }}</p>
                        @if(0 < $product->discount)
                            <p><strong>Цена: </strong><span class="old-price">{{ $product->price }}</span> <span class="price">{{ floor(($product->price*(0.1-$product->discount/1000)))*10 }}</span> <span class="glyphicon glyphicon-ruble" aria-hidden="true"></span></p>
                        @else
                            <p><strong>Цена: </strong><span class="price">{{ $product->price }}</span><span class="glyphicon glyphicon-ruble" aria-hidden="true"></span></p>
                        @endif
                        <span class="buy btn" productId="{{ $product->id }}"><span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span> Купить</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection