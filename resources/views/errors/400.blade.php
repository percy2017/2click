@extends('frontend.layouts.app')
@section('mystyle')
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2>
                            Error
                        </h2>
                    </div>

                    <div class="panel-body">
                    <h3>
                        Error 400
                    </h3>
                    <h1>
                         para Solicitud incorrecta
                    </h1>
                    <p>Ups. Ocurrio un error, lamentamos las molestias. estamos trabajando para corregirlo, Gracias</p>
                    <a href="{{ URL::previous() }}"></a>
                    </div>
                    <div class="panel-footer text-center">
                        {{ config('app.myfooter') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('myscript')
@endsection

