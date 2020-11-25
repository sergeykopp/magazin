@extends('client')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Регистрация</h3>
        </div>
        <div class="panel-body">
            <form class="auth" method="post" action="{{ route('register') }}">
                {{ csrf_field() }}
                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    <label>Имя</label>
                    @if ($errors->has('name'))
                        <span class="help-block">{{ $errors->first('name') }}</span>
                    @endif
                    <input id="name" type="text" class="form-control" name="name" placeholder="обязательное поле" value="{{ old('name') }}" autofocus />
                </div>
                <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                    <label>Телефон</label>
                    @if ($errors->has('phone'))
                        <span class="help-block">{{ $errors->first('phone') }}</span>
                    @endif
                    <input id="phone" type="text" class="form-control" name="phone" placeholder="обязательное поле" value="{{ old('phone') }}" />
                </div>
                <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                    <label>Адрес доставки</label>
                    @if ($errors->has('address'))
                        <span class="help-block">{{ $errors->first('address') }}</span>
                    @endif
                    <input id="address" type="text" class="form-control" name="address" placeholder="обязательное поле" value="{{ old('address') }}" />
                </div>
                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label>Электронная почта</label>
                    @if ($errors->has('email'))
                        <span class="help-block">{{ $errors->first('email') }}</span>
                    @endif
                    <input id="email" type="text" class="form-control" name="email" placeholder="обязательное поле" value="{{ old('email') }}" />
                </div>
                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <label>Пароль</label>
                    @if ($errors->has('password'))
                        <span class="help-block">{{ $errors->first('password') }}</span>
                    @endif
                    <input id="password" type="password" class="form-control" name="password" placeholder="Не менее 8 символов"/>
                </div>
                <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                    <label>Подтверждение пароля</label>
                    @if ($errors->has('password_confirmation'))
                        <span class="help-block">{{ $errors->first('password_confirmation') }}</span>
                    @endif
                    <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" placeholder="Не менее 8 символов" />
                </div>
                <button type="submit" class="btn pull-right">Зарегистрировать</button>
            </form>
        </div>
        <div class="panel-footer text-center">
            <h3 class="panel-title">
                <a href="{{ route('login') }}">Войти в личный кабинет</a>
            </h3>
        </div>
    </div>

{{--<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Register</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Register
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>--}}
@endsection
