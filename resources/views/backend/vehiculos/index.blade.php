@extends('backend.layouts.app')

@section('content')

<div id="cargando" class="text-center">
    <img src="{{ asset('imagenes/espera.gif') }}" alt="" style="width: 200px; height: 200px;">
</div>
<div id="cargado" style="display:none;">
    @include('backend.vehiculos.create')
    <div class="container">
        @if(\Session::has('mensaje_info'))
            <div class="alert alert-info alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong>Info!</strong> {{ \Session::get('mensaje_info') }}
            </div>
        @endif
        <div class="row">
            <div class="col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3>
                            <i class="fa fa-truck"></i>
                            Vehiculos
                            <div class="pull-right">
                                <a href="#" data-toggle="modal" data-target="#modal_vehiculo_create" class="btn btn-primary"><i class="fa fa-plus"></i> Nuevo</a>
                                <a href="{{ URL::previous() }}" class="btn btn-danger"><i class="fa fa-reply"></i> Atras</a>
                            </div>
                        </h3> 
                    </div>
                
                    <div class="panel-body">                     
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead> 
                                    <tr> 
                                        <th>#</th> 
                                        <th>Nombre</th> 
                                        <th>Ruedas</th> 
                                        <th>Creado</th> 
                                        <th>Acciones</th> 
                                    </tr> 
                                </thead>
                                <tbody> 
                                    @foreach($vehiculos as $item)
                                    <tr>                                 
                                        <th>{{$item->id}}</th> 
                                        <td>{{$item->nombre}}</td>
                                        <td>{{$item->ruedas}}</td> 
                                        <td>{{ \Carbon\Carbon::parse($item->updated_at)->diffForHumans() }}</td>
                                        <td class="text-center">
                                            <a href="#" class="btn btn-xs btn-primary">Ver</a>
                                        </td> 
                                    </tr> 
                                    @endforeach
                                </tbody>
                            </table>
                        </div>                        
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
<script>
    $(document).ready(function() 
    {
        document.getElementById('cargando').style.display = 'none';
        document.getElementById('cargado').style.display = 'block';
    });
</script>
@endsection
