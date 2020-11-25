@extends('client')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">{{ $title }}</h3>
        </div>
        <div class="panel-body">
            <div class="alert alert-info" role="alert">
                <h3>Уважаемый покупатель!</h3>
                <p>Ваш заказ №{{ $orderNumber }} оформлен. В ближайшее время с Вами свяжестся специалист для подтверждения данных по заказу.</p>
                <p>Телефон: {{ $phone }}</p>
                <p>Адрес доставки: {{ $address }}</p>
            </div>
        </div>
    </div>
@endsection