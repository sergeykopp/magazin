@extends('client')

@section('content')
    @if(0 < count($files))
        <div class="panel panel-default">
            <div class="panel-body">
                <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                    <!-- Indicators -->
                    <ol class="carousel-indicators">
                        @foreach($files as $key => $file)
                            @if(0 == $key)
                                <li data-target="#carousel-example-generic" data-slide-to="{{ $key }}" class="active"></li>
                            @else
                                <li data-target="#carousel-example-generic" data-slide-to="{{ $key }}"></li>
                            @endif
                        @endforeach
                    </ol>

                    <!-- Wrapper for slides -->
                    <div class="carousel-inner" role="listbox">
                        @foreach($files as $key => $file)
                            @if(0 == $key)
                                <div class="item active">
                                    <div class="text-center">
                                        <img src="/images/products/carousel/{{ $file }}">
                                    </div>
                                </div>
                            @else
                                <div class="item">
                                    <div class="text-center">
                                        <img src="/images/products/carousel/{{ $file }}">
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>

                    <!-- Controls -->
                    <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        </div>
    @endif
@endsection