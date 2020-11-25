@extends('admin')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Резервное копирование</h3>
        </div>
        <div class="panel-body">
            <form method="post">
                {{ csrf_field() }}
                @if (session()->has('backup'))
                    <div class="alert alert-success">
                        {{ session()->get('backup') }}
                    </div>
                @endif
                @if (session()->has('error'))
                    <div class="alert alert-danger">
                        {{ session()->get('error') }}
                    </div>
                @endif
                <div class="form-group">
                    <input type="button" class="btn" name="export" value="Экспорт в XML"
                           onclick="if(confirm('Вы уверены, что хотите экспортировать данные в файл?')) this.setAttribute('type', 'submit');"/>
                </div>
                <div class="form-group">
                    <input type="button" class="btn" name="import" value="Импорт из XML"
                           onclick="if(confirm('Вы уверены, что хотите импортировать данные из файла?')) this.setAttribute('type', 'submit');"/>
                </div>
            </form>
        </div>
    </div>
@endsection