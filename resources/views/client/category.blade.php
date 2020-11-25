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
                        <form name="options" class="form-inline" method="post">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label>Показывать по:</label>
                                <select name="paginationQuantity" onchange="document.options.submit();">
                                    @for($i=5;$i<=30;$i+=5)
                                        <option value="{{ $i }}" {{ ($i == $paginationQuantity) ? 'selected' : ''  }}>{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Сортировать по:</label>
                                <select name="paginationSorting" onchange="document.options.submit();">
                                    <option value="name" {{ ('name' == $paginationSorting) ? 'selected' : ''  }}>Наименование</option>
                                    <option value="artikul" {{ ('artikul' == $paginationSorting) ? 'selected' : ''  }}>Артикул</option>
                                    <option value="price" {{ ('price' == $paginationSorting) ? 'selected' : ''  }}>Цена</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Порядок сортировки:</label>
                                <select name="paginationDirection" onchange="document.options.submit();">
                                    <option value="up" {{ ('up' == $paginationDirection) ? 'selected' : ''  }}>Возрастание</option>
                                    <option value="down" {{ ('down' == $paginationDirection) ? 'selected' : ''  }}>Убывание</option>
                                </select>
                            </div>
                        </form>
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
                                    <p>Цена: <span class="old-price">{{ $product->price }}</span> <span class="price">{{ floor(($product->price*(0.1-$product->discount/1000)))*10 }}</span><span class="glyphicon glyphicon-ruble" aria-hidden="true"></span></p>
                                @else
                                    <p>Цена: <span class="price">{{ $product->price }}</span><span class="glyphicon glyphicon-ruble" aria-hidden="true"></span></p>
                                @endif
                                <span class="buy btn" productId="{{ $product->id }}"><span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span> Купить</span>
                            </div>
                        @endforeach
                    @endif
                    {{--Постраничная навигация--}}
                    @if($quantityPages > 1)
                        <form name="pagination" method="post">
                            {{ csrf_field() }}
                            <input name="currentPage" type="hidden" />
                            <!-- Ссылка на первую страницу -->
                            @if(1 < $limitPages['firstPage'])
                                @if(2 == $limitPages['firstPage'])
                                    <span class="btn paginationLink" onclick="document.pagination.currentPage.value=1; document.pagination.submit();">1</span>
                                @else
                                    <span class="btn paginationLink" onclick="document.pagination.currentPage.value=1; document.pagination.submit();">Первая</span>
                                    <span class="paginationUnlink">...</span>
                                @endif
                            @endif

                            <!-- Вывод ссылок страниц до текущей страницы -->
                            @for($i = $limitPages['firstPage']; $i < $currentPage; $i++)
                                <span class="btn paginationLink" onclick="document.pagination.currentPage.value={{ $i }}; document.pagination.submit();">{{ $i }}</span>
                            @endfor

                            <!-- Вывод номера текущей страницы -->
                            @if($quantityPages > 1)
                                <span class="btn paginationUnlink">
                                    @if($quantityPages != 1)
                                        {{ $currentPage }}
                                    @endif
                                </span>
                            @endif

                            <!-- Вывод ссылок страниц после текущей страницы -->
                            @for($i = $currentPage + 1; $i <= $limitPages['lastPage']; $i++)
                                <span class="btn paginationLink" onclick="document.pagination.currentPage.value={{ $i }}; document.pagination.submit();">{{ $i }}</span>
                            @endfor

                            <!-- Ссылка на последнюю страницу -->
                            @if($limitPages['lastPage'] != $quantityPages)
                                @if($limitPages['lastPage'] + 1 == $quantityPages)
                                    <span class="btn paginationLink" onclick="document.pagination.currentPage.value={{ $quantityPages }}; document.pagination.submit();">{{ $quantityPages }}</span>
                                @else
                                    <span class="paginationUnlink">...</span>
                                    <span class="btn paginationLink" onclick="document.pagination.currentPage.value={{ $quantityPages }}; document.pagination.submit();">Последняя</span>
                                @endif
                            @endif
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection