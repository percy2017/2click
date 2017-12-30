@extends('frontend.layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Acceso denegado</div>

                <div class="panel-body">

                    <h3 class="text-center">
                        {{Auth::user()->name }}, el sistema  {{ config('app.name') }} ha denegado el acceso a la interface solicitada.
                    </h3>
                    
                    <div class="text-center"><a href="{{ URL::previous() }}" class="btn btn-primary">Atras</a></div>
                    
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
