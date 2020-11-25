@extends('client')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">{{ $title }}</h3>
        </div>
        <div class="panel-body">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                @include('client.delivery')
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <form method="post" action="{{ route('storeOrder') }}">
                    {{ csrf_field() }}
                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Обращение</label>
                        <input type="text" class="form-control" name="name" value="{{ old('name') ?? ((true == Auth::guest()) ? '' : Auth::user()->name) }}" autofocus />
                    </div>
                    <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                        <label><span class="glyphicon glyphicon-phone" aria-hidden="true"></span> Телефон</label>
                        @if ($errors->has('phone'))
                            <span class="help-block">{{ $errors->first('phone') }}</span>
                        @endif
                        <input type="text" class="form-control" name="phone" placeholder="обязательное поле" value="{{ old('phone') ?? ((true == Auth::guest()) ? '' : Auth::user()->phone) }}" />
                    </div>
                    <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                        <label><span class="glyphicon glyphicon-home" aria-hidden="true"></span> Адрес доставки</label>
                        @if ($errors->has('address'))
                            <span class="help-block">{{ $errors->first('address') }}</span>
                        @endif
                        <input type="text" class="form-control" name="address" placeholder="обязательное поле" value="{{ old('address') ?? ((true == Auth::guest()) ? '' : Auth::user()->address) }}" />
                    </div>
                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> Электронная почта</label>
                        @if ($errors->has('email'))
                            <span class="help-block">{{ $errors->first('email') }}</span>
                        @endif
                        <input type="text" class="form-control" name="email" value="{{ old('email') ?? ((true == Auth::guest()) ? '' : Auth::user()->email) }}" />
                    </div>
                    <button type="submit" class="btn pull-right">Оформить</button>
                </form>
            </div>
        </div>
    </div>
@endsection