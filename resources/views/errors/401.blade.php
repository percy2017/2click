@extends('frontend.layouts.app')
@section('mystyle')
@endsection
@section('content')
<div id="cargando" class="text-center">
    <img src="{{ asset('imagenes/espera.gif') }}" alt="" style="width: 200px; height: 200px;">
</div>
<div id="cargado" style="display:none;">
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
                        Error 401
                    </h3>
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
</div>
@endsection
@section('myscript')
@endsection

