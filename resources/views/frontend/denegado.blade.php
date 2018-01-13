@extends('frontend.layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3 col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-lock"></i> Acceso denegado</div>

                <div class="panel-body">
                    <h3 class="text-center">
                        {{Auth::user()->name }}, el sistema  {{ config('app.name') }} ha denegado el acceso a la interface solicitada.
                    </h3>
                    <hr>
                    <div class="text-center"><a href="{{ URL::previous() }}" class="btn btn-danger"><i class="fa fa-reply"></i> Atras</a></div>
                    
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
